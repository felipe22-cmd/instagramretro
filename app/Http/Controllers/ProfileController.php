<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        return response()->json([
            'user'       => $user->load('profile'),
            'post_count' => $user->posts()->count(),
            'posts'      => $user->posts()->with(['likes','comments'])->latest()->get(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'bio'    => 'nullable|string|max:150',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $profile = $request->user()->profile;

        if ($request->hasFile('avatar')) {
            if ($profile->avatar) {
                Storage::disk('public')->delete($profile->avatar);
            }
            $profile->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->has('bio')) {
            $profile->bio = $request->bio;
        }

        $profile->save();
        return response()->json($profile);
    }
}