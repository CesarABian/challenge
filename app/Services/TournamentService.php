<?php

namespace App\Services;

use App\Models\Player;
use App\Repositories\Interfaces\GameRepositoryInterface;
use App\Repositories\Interfaces\PlayerRepositoryInterface;
use App\Repositories\Interfaces\TournamentRepositoryInterface;

class TournamentService extends Service
{
    /**
     * @var TournamentRepositoryInterface
     */
    protected $repository;

    /**
     * @var GameRepositoryInterface
     */
    protected $gameRepository;

    /**
     * @var PlayerRepositoryInterface
     */
    protected $playerRepository;

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
     * createPlayers
     *
     * @param  array $data
     * @return array
     */
    protected function createPlayers(array $data): array
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
        shuffle($players);
        $length = intval(count($players)/2);
        $playersA = array_chunk($players, $length);
        $playersB = array_chunk($players, $length);
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
     * playMale
     *
     * @param  Player $playerA
     * @param  Player $playerB
     * @return Player
     */
    protected function playMale(Player $playerA, Player $playerB): Player
    {
// ● habilidad y suerte ganador.
// ● fuerza y velocidad ganador.
        $toCompare = ['ability', 'force', 'velocity'];
        return new Player;
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
// ● habilidad y suerte ganador.
// ● reacción ganador.
        return new Player;
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
        foreach ($playersA as $key => $playerA) {
            $currentWinner = $this->playBetween($playerA, $playersB[$key], $genre);
        }
        return $winner;
    }
    
    /**
     * start
     *
     * @param  array $data
     * @return Player
     */
    public function start(array $data): Player
    {
        $this->repository->truncate();
        $this->gameRepository->truncate();
        $this->playerRepository->truncate();
        [$playersA, $playersB, $genre] = $this->createPlayers($data['data']);
        $winner = $this->startGames($playersA, $playersB, $genre);
        $this->store([
            'name' => 'default',
            'genre' => $genre,
            'winner_id' => $winner->id,
        ]);
        return $winner;
    }
}