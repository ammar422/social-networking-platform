<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Requests\PhotoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index():View
    {
        $users=User::with('profile')->get();
        return view('all-users',['users'=>$users]);
    }

    public function show($id)
    {
        $userData = User::with(['posts','profile'])->findOrFail($id);
        return view('dashboard', [
            'user' => $userData
        ]);
    }


    public function edit($id)
    {
        $user =  User::with('profile')->findOrFail($id);
        return view('profile.edit', [
            'user' =>$user 
        ]);
    }

    public function create()
    {
        //    
    }
    public function store()
    {
        // 
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        Profile::where('user_id', $request->user()->id)
            ->update(['bio' => $request->validated('bio')]);
        $request->user()->save();

        return Redirect::route('profile.edit', auth()->id())->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    public function photo_upload(PhotoRequest $request)
    {
        $path = uploadImage('profile_photo', $request->validated('photo'));
        Profile::where('user_id', auth()->id())->update([
            'photo' => $path
        ]);
        return Redirect::route('profile.edit', auth()->id())->with('status', 'profile-updated');
    }
}
