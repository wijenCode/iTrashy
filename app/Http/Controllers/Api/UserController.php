<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();
        if($users) {
            return UserResource::collection($users);
        }
        else {
            return response()->json([
                'message' => 'Data not found'
            ], 404);
        }
    }
}