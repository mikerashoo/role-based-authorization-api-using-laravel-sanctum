<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    public function create(Request $request){
        // Validate request data
        $validator = Validator::make($request->all(), [
           'name' => 'required|string|max:255',
           'email' => 'required|email|unique:users|max:255',
       ]);
       // Return errors if validation error occur.
       if ($validator->fails()) {
           $errors = $validator->errors();
           return response()->json(['error' => $errors ],
           400);
       }
       // Check if validation pass then create user and auth token. Return the auth token
       if ($validator->passes()) {
           $role = Role::where('name', 'ADMIN')->first();

           if(!$role){
               $role = Role::create([
                   'name' => 'ADMIN',
                   'is_editable' => false
               ]);
           }

           $user = User::create([
               'name' => $request->name,
               'email' => $request->email,
               'role_id' => $role->id,
               'password' => Hash::make('12345678')
           ]);
           return response()->json([
               'user' => $user,
           ]);
       }
   }
}
