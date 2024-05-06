<?php

namespace App\Http\Controllers;

use App\Mail\AdminMail;
use App\Mail\VerifyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function postEmail(Request $request)
    {
        $request->validate(['email' => 'email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        echo $status;

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['status', __($status)]);
        }

        return response()->json(['email' => __($status)]);
    }
}
