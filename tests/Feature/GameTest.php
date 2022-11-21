<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class GameTest extends PlayerTest
{
    /**
     * testGame
     *
     * @return void
     */
    public function testGame(): void
    {
        $token = $this->testSingUp();
        // $this->storeGame($token);
    }
}
