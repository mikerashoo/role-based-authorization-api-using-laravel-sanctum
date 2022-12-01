<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function list(Request $request)
    {
        $userRoleId = Role::where('name', 'USER')->first()->id;
        return User::where('role_id', $userRoleId)->get();
    }
}
