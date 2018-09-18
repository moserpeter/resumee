<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn(array $attributes = [], $guard = 'web')
    {
        $user = factory(\App\User::class)->create($attributes);

        $this->be($user, $guard);
    }
    
    public function apiSignIn(array $attributes = [])
    {
        $user = factory(\App\User::class)->create($attributes);

        $this->be($user, 'api');
    }
}
