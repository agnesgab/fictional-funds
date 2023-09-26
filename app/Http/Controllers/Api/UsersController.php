<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = (new UserService($id));
        $user = $service->getUserData();

        return UsersResource::collection($user);
    }
}
