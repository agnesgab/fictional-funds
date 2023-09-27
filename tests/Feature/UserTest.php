<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\UserService;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_user_data_retrieved()
    {
        $service = new UserService(1);
        $result = $service->getUserData();

        $this->assertInstanceOf(User::class, $result[0]);
    }
}
