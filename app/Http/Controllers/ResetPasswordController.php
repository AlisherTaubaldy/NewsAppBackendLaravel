<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function getForm(Request $request, $token)
    {
        $email = $request->query('email');

        $user = User::where('email', $email)
            ->first();

        $status = Password::tokenExists($user, $token);

        if ($status === Password::INVALID_TOKEN) {
            return response()->json('status', __($status));
        }

        return view('reset', compact('token', 'email'));
    }

    public function postReset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'token'),
            fn ($user) => $user->forceFill([
                'password' => $request->password
            ])->save()
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        } else {
            return back()->withErrors(['email' => __($status)]); // Use translated error message
        }
    }
}
