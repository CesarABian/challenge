<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;

class TournamentTest extends AbstractApiTest
{
    use WithFaker;

    /**
     * @var int $players
     */
    protected int $players = 8;

    /**
     * @var string $genre
     */
    protected string $genre = 'f';
    
    /**
     * fakePlayer
     *
     * @return array
     */
    protected function fakePlayer(): array
    {
        return [
            "name" => $this->faker->firstName,
            "last_name" => $this->faker->lastName,
            "ability" => $this->faker->numberBetween(0, 100),
            "force" => $this->faker->numberBetween(0, 100),
            "velocity" => $this->faker->numberBetween(0, 100),
            "reaction" => $this->faker->numberBetween(0, 100),
            "genre"  => $this->genre,
        ];
    }
    
    /**
     * createPlayers
     *
     * @return array
     */
    protected function createPlayers(): array
    {
        $players['data'] = [];
        for ($i=0; $i < $this->players; $i++) { 
            $players['data'] []= $this->fakePlayer();
        }
        return $players;
    }
    
    /**
     * startTournament
     *
     * @param  string $token
     * @param  array $players
     * @return void
     */
    protected function startTournament(string $token, array $players): void
    {
        $json = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('POST', '/api/tournament/start', $players);
        $json->assertJson([
            'data' => ['winner' => []],
        ]);
    }

    /**
     * TestTournament.
     *
     * @return void
     */
    public function testTournament(): void
    {
        $token = $this->testSingUp();
        $players = $this->createPlayers();
        $this->startTournament($token, $players);
    }
}
