<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(Request $request)
    {
        // Get the user by ID from the URL
        $user = User::findOrFail($request->route('id'));

        // Verify the hash matches
        if (!hash_equals(sha1($user->getEmailForVerification()), (string) $request->route('hash'))) {
            abort(403, 'Invalid verification link.');
        }

        // Check if already verified
        if ($user->hasVerifiedEmail()) {
            // If user is logged in, go to dashboard
            if (Auth::check()) {
                return redirect()->route('dashboard')->with('success', 'Email already verified!');
            }
            // If not logged in, go to login
            return redirect()->route('login')->with('success', 'Email already verified! Please login.');
        }

        // Mark email as verified
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        // Log the user in automatically
        Auth::login($user);

        // Show success page
        return view('auth.verified');
    }
}
