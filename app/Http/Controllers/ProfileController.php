<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Controllers\Concerns\HandlesImageUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    use HandlesImageUploads;

    public function edit()
    {
        $user       = Auth::user();
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        return view('profile.edit', compact('user', 'categories'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'                   => ['required', 'string', 'max:255'],
            'email'                  => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'bio'                    => ['nullable', 'string', 'max:500'],
            'favorite_fandoms'       => ['nullable', 'array'],
            'categories_of_interest' => ['nullable', 'array'],
            'display_preference'     => ['in:grid,list'],
            'font_size'              => ['in:small,medium,large'],
            'dark_mode'              => ['boolean'],
            'avatar'                 => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $data = $request->only([
            'name', 'email', 'bio', 'favorite_fandoms',
            'categories_of_interest', 'display_preference', 'font_size',
        ]);
        $data['dark_mode'] = $request->boolean('dark_mode');

        // Handle avatar upload
        if ($avatar = $this->storeUploadedImage($request, 'avatar', 'avatars', $user->avatar)) {
            $data['avatar'] = $avatar;
        }

        $user->update($data);

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'confirmed', 'min:8'],
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        Auth::user()->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password updated successfully!');
    }
}
