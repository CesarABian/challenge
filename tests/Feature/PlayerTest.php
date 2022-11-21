<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class PlayerTest extends AbstractApiTest
{    
    /**
     * @var array $storeData
     */
    protected array $storeData = [
        "name" => "Sally",
        "last_name" => "Test",
        "ability" => "99",
        "force" => "99",
        "velocity" => "99",
        "reaction" => "99",
        "genre" => "f",
    ];

    /**
     * @var array $updateData
     */
    protected array $updateData = [
        "velocity" => "88",
    ];

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
     * @return int
     */
    protected function updatePlayer(int $id, string $token): int
    {
        $json = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('PUT', "/api/player/$id", $this->updateData);
        $json->assertJson([
            'data' => [],
        ]);
        return $json->json()['data']['id'];
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
        $id = $this->storePlayer($token, $this->storeData);
        $this->updatePlayer($id, $token);
        $this->deletePlayer($id, $token);
    }
}
