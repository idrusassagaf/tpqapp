<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save(); // ← WAJIB ADA

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profile updated successfully.');
    }

    public function destroy(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        Auth::logout();

        $user->delete(); // sekarang tidak merah

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
