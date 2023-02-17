<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Check;
use App\Models\User;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        if(!Check::isAdmin()) {
            return redirect('/dashboard');
        }

        $validated = $request->validateWithBag('updatePassword', [
            // 'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        //! for auth current user
        // $request->user()->update([
        //     'password' => Hash::make($validated['password']),
        // ]);

        $user = User::find($id);
        $user->password = Hash::make($validated['password']);
        $user->save();

        return back()->with('status', 'password-updated');
    }
}
