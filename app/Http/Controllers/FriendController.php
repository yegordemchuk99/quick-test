<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'status' => 'success',
            'message' => 'inviters was returned',
            'users' => $user->friends
        ]);
    }
}
