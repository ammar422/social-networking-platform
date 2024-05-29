<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{
    public function sendRequest($id)
    {
        $friend = User::findOrFail($id);

        Friendship::create([
            'user_id' => Auth::id(),
            'friend_id' => $friend->id,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Friend request sent!');
    }

    public function acceptRequest($id)
    {
        $request = Friendship::findOrFail($id);
        $request->update(['status' => 'accepted']);

        return redirect()->back()->with('success', 'Friend request accepted!');
    }

    public function rejectRequest($id)
    {
        $request = Friendship::findOrFail($id);
        $request->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Friend request rejected!');
    }

    public function listFriends()
    {
        $friends = Auth::user()->friends;

        return view('friends.list', compact('friends'));
    }

    public function listOfRequestsFriends()
    {
        $requests = Auth::user()->friendRequests;

        return view('friends.requests', compact('requests'));
    }
}
