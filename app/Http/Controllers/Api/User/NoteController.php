<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{

    public function index()
    {
        $userId = Auth::user()->id;
        return Note::where('user_id', $userId)->get();
    }

    public function create(Request $request){
        // Validate request data
        $validator = Validator::make($request->all(), [
           'note' => 'required|string',
       ]);

       // Return errors if validation error occur.
       if ($validator->fails()) {
           $errors = $validator->errors();
           return response()->json(['error' => $errors ],
           400);
       }
       // Check if validation pass then create user and auth token. Return the auth token
       if ($validator->passes()) {
           $userId = Auth::user()->id;
           $note = Note::create([
               'note' => $request->note,
               'user_id' => $userId
           ]);
           return response()->json([
               'note' => $note,
           ]);
       }
   }
}
