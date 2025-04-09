<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = User::findOrFail(Auth::id());
        return view('admin.profile.index', compact('profile'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->name = $request->name;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect()->route('profile.index');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'max:10240']
        ]);

        $user = User::findOrFail(Auth::user()->id);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = 'avatar_' . $user->id . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('public/profile-photos', $filename);

            $user->profile_photo_path = 'profile-photos/' . $filename;
            $user->save();
        }

        return redirect()->route('profile.index');
    }
}
