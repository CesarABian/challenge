<?php

namespace Tests\Feature;

use App\Models\User;

class AuthTest extends AbstractApiTest
{
    /**
     * testAuth
     *
     * @return void
     */
    public function testAuth(): void
    {
        $this->testSingUp();
        $token = $this->testLogin();
        $this->testLogout($token);
    }
}