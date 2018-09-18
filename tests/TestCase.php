<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn(array $attributes = [], $guard = 'web') : \App\User
    {
        $user = factory(\App\User::class)->create($attributes);

        $this->be($user, $guard);

        return $user;
    }
    
    public function apiSignIn(array $attributes = []) : \App\User
    {
        $user = factory(\App\User::class)->create($attributes);

        $this->be($user, 'api');

        return $user;
    }
}
