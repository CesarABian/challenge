<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;

class PlayerTest extends AbstractApiTest
{    
    use WithFaker;

    /**
     * @var string $genre
     */
    protected string $genre = 'f';

    /**
     * @var array $updateData
     */
    protected array $updateData = [
        "velocity" => "88",
    ];

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
     * storePlayer
     *
     * @param  string $token
     * @param  array $storeData
     * @return int
     */
    protected function storePlayer(string $token, array $storeData): int
    {
        $json = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('POST', '/api/player', $storeData);
        $json->assertJson([
            'data' => [],
        ]);
        return $json->json()['data']['id'];
    }
    
    /**
     * updatePlayer
     *
     * @param  int $id
     * @param  string $token
     * @return void
     */
    protected function updatePlayer(int $id, string $token): void
    {
        $json = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('PUT', "/api/player/$id", $this->updateData);
        $json->assertJson([
            'data' => [],
        ]);
    }

    /**
     * deletePlayer
     *
     * @param  int $id
     * @param  string $token
     * @return void
     */
    protected function deletePlayer(int $id, string $token): void
    {
        $json = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('DELETE', "/api/player/$id");
        $json->assertJson([
            'status' => true,
        ]);
    }

    /**
     * testPlayer
     *
     * @return void
     */
    public function testPlayer(): void
    {
        $token = $this->testSingUp();
        $id = $this->storePlayer($token, $this->fakePlayer());
        $this->updatePlayer($id, $token);
        $this->deletePlayer($id, $token);
    }
}
