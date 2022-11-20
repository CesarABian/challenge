<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

abstract class AbstractApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * sing up test section
     *
     * @return void
     */
    protected function testSingUp(): void
    {
        $json = $this->json('POST', '/api/auth/register', [
            'name' => 'Sally',
            'email' => 'sally@test.com',
            'password' => 'Test4Pass!',
            'password_confirmation' => 'Test4Pass!',
        ]);
        $json->assertJson([
                'status' => true,
        ]);
    }
    
    /**
     * login test section
     *
     * @return string
     */
    protected function testLogin(): string
    {
        $json = $this->json('POST', '/api/auth/login', [
            'email' => 'sally@test.com',
            'password' => 'Test4Pass!',
        ]);
        $json->assertJson([
                'status' => true,
        ]);
        return $json->json()['token'];
    }
    
    /**
     * logout test section
     *
     * @param  string $token
     * @return void
     */
    protected function testLogout(string $token): void
    {
        $json = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('POST', '/api/auth/logout');
        $json->assertJson([
                'status' => true,
        ]);
    }
}