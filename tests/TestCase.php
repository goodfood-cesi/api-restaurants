<?php

use App\Models\User;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    public function fakeLogin() {
        $user = User::factory()->create();
        return JWTAuth::fromUser($user);
    }
}
