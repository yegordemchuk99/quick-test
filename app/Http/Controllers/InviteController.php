<?php

namespace App\Http\Controllers;

use App\Friend;
use App\Inviter;
use Illuminate\Http\Request;

class InviteController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'status' => 'success',
            'message' => 'inviters was returned',
            'users' => $user->inviters
        ]);
    }

    public function accept(Request $request)
    {
        $request->validate([
            'inviter_id' => 'required|integer',
        ]);

        $inviter_id = $request->inviter_id;

        $user = $request->user();

        $invite = Inviter::where('user_id', $user->id)->where('inviter_id', $inviter_id)->first();

        if (!$invite) {
            return response()->json([
                'status' => 'error',
                'message' => 'invitor not found',
            ]);
        }

        Friend::firstOrCreate(['user_id' => $user->id, 'friend_id' => $inviter_id]);
        Friend::firstOrCreate(['user_id' => $inviter_id, 'friend_id' => $user->id]);

        $invite->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'invite accepted',
        ]);
    }

    public function decline(Request $request)
    {
        $request->validate([
            'inviter_id' => 'required|integer',
        ]);

        $inviter_id = $request->inviter_id;

        $user = $request->user();

        $invite = Inviter::where('user_id', $user->id)->where('inviter_id', $inviter_id)->first();

        if (!$invite) {
            return response()->json([
                'status' => 'error',
                'message' => 'invitor not found',
            ]);
        }

        $invite->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'invite was deleted',
        ]);
    }

    public function invite(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
        ]);

        $user_id = $request->user_id;

        $inviter = $request->user();

        if (Friend::where('user_id', $user_id)->where('friend_id', $inviter->id)->first()) {
            return response()->json([
                'status' => 'error',
                'message' => 'user is friend already ',
            ]);
        }

        Inviter::firstOrCreate(['user_id' => $user_id, 'inviter_id' => $inviter->id]);

        return response()->json([
            'status' => 'success',
            'message' => 'invite was created',
        ]);
    }
}
