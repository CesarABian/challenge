<?php

namespace App\Services;

use App\Models\Player;
use App\Models\Tournament;
use App\Repositories\Interfaces\GameRepositoryInterface;
use App\Repositories\Interfaces\PlayerRepositoryInterface;
use App\Repositories\Interfaces\TournamentRepositoryInterface;

class TournamentService extends Service
{
    /**
     * @var float
     */
    protected float $lucky = 0.9;

    /**
     * @var TournamentRepositoryInterface
     */
    protected $repository;

    /**
     * @var GameRepositoryInterface
     */
    protected GameRepositoryInterface $gameRepository;

    /**
     * @var PlayerRepositoryInterface
     */
    protected PlayerRepositoryInterface $playerRepository;

    /**
     * __construct
     *
     * @param  TournamentRepositoryInterface $repository
     * @param  GameRepositoryInterface $gameRepository
     * @param  PlayerRepositoryInterface $playerRepository
     * @return void
     */
    public function __construct(
        TournamentRepositoryInterface $repository,
        GameRepositoryInterface $gameRepository,
        PlayerRepositoryInterface $playerRepository,
    ) {
        $this->repository = $repository;
        $this->gameRepository = $gameRepository;
        $this->playerRepository = $playerRepository;
    }
    
    /**
     * createShufflePlayers
     *
     * @param  array $data
     * @return array
     */
    protected function createShufflePlayers(array $data): array
    {
        if(count($data) % 2 != 0){
            throw new \Exception('the contain data should be even'); 
        }
        $players = [];
        $genre = null;
        /**
         * @var array $player
         */
        foreach ($data as $player) {
            if ($genre && $genre != $player['genre']) {
                throw new \Exception('the genre needs to be the same on all player'); 
            }
            $players []= $this->playerRepository->store($player);
            $genre = $player['genre'];
        }
        [$playersA, $playersB] = $this->sortPlayers($players);
        return [$playersA, $playersB, $genre];
    }
    
    /**
     * playBetween
     *
     * @param  Player $playerA
     * @param  Player $playerB
     * @param  string $genre
     * @return Player
     */
    protected function playBetween(Player $playerA, Player $playerB, string $genre): Player
    {
        switch ($genre) {
            case 'm':
                return $this->playMale($playerA, $playerB);
            default:
                return $this->playFemale($playerA, $playerB);
        }
    }
    
    /**
     * play
     *
     * @param  Player $playerA
     * @param  Player $playerB
     * @param  array $toCompare
     * @return Player
     */
    protected function play(Player $playerA, Player $playerB, array $toCompare): Player
    {
        $points = ['playerA' => 0.0, 'playerB' => 0.0];
        foreach ($toCompare as $property) {
            if ($playerA->$property > $playerB->$property) {
                $points['playerA'] = $points['playerA'] + $playerA->$property - $playerB->$property;
            } elseif ($playerA->$property < $playerB->$property) {
                $points['playerB'] = $points['playerB'] + $playerB->$property - $playerA->$property;
            }
        }
        $keys = array_keys($points);
        shuffle($keys);
        $points[$keys[0]] = $points[$keys[0]] * $this->lucky;
        if ($points['playerA'] > $points['playerB']) {
            return $playerA;
        } elseif ($points['playerA'] < $points['playerB']) {
            return $playerA;
        } else {
            $players = [$playerA, $playerB];
            shuffle($players);
            return $players[0];
        }
    }
    
    /**
     * playMale
     *
     * @param  Player $playerA
     * @param  Player $playerB
     * @return Player
     */
    protected function playMale(Player $playerA, Player $playerB): Player
    {
        $toCompare = ['ability', 'force', 'velocity'];
        return $this->play($playerA, $playerB, $toCompare);
    }
    
    /**
     * playFemale
     *
     * @param  Player $playerA
     * @param  Player $playerB
     * @return Player
     */
    protected function playFemale(Player $playerA, Player $playerB): Player
    {
    $toCompare = ['ability', 'reaction'];
    return $this->play($playerA, $playerB, $toCompare);
    }
    
    /**
     * startGames
     *
     * @param  array $playersA
     * @param  array $playersB
     * @param  string $genre
     * @return Player
     */
    protected function startGames(array $playersA, array $playersB, string $genre): Player
    {
        /**
         * @var mixed $key
         * @var Player $playerA
         */
        $players = [];
        foreach ($playersA as $key => $playerA) {
            $winner = $this->playBetween($playerA, $playersB[$key], $genre);
            $players []= $winner;
            $this->gameRepository->store([
                'player_a_id' => $playerA->id,
                'player_b_id' => $playersB[$key]->id,
                'winner_id' => $winner->id,
            ]);
        }
        if (count($players) != 1) {
            [$playersA, $playersB] = $this->sortPlayers($players);
            return $this->startGames($playersA, $playersB, $genre);
        }
        return $players[0];
    }
    
    /**
     * sortPlayers
     *
     * @param  array $players
     * @return array
     */
    protected function sortPlayers(array $players): array
    {
        shuffle($players);
        $length = intval(count($players)/2);
        $playersA = array_slice($players, 0, $length);
        $playersB = array_slice($players, $length, $length);
        return [$playersA, $playersB];
    }
    
    /**
     * start
     *
     * @param  array $data
     * @return Tournament
     */
    public function start(array $data): Tournament
    {
        $this->repository->truncate();
        $this->gameRepository->truncate();
        $this->playerRepository->truncate();
        [$playersA, $playersB, $genre] = $this->createShufflePlayers($data['data']);
        $winner = $this->startGames($playersA, $playersB, $genre);
        return $this->store([
            'name' => 'default',
            'genre' => $genre,
            'winner_id' => $winner->id,
        ]);
    }
}