<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProfileUpdatedMail;
use App\Mail\EmailChangedMail;
use App\Mail\AccountDeletedMail;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $oldEmail = $user->email;
        $emailChanged = false;

        // Check if email changed
        if ($request->email !== $oldEmail) {
            $emailChanged = true;

            // Send notification to old email
            Mail::to($oldEmail)->send(new EmailChangedMail($user, $request->email));

            // Reset email verification
            $user->email_verified_at = null;
        }

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Send verification email to new email if changed
        if ($emailChanged) {
            $user->sendEmailVerificationNotification();

            return Redirect::route('profile.edit')
                ->with('success', 'Profile updated! Please check your new email to verify it.')
                ->with('status', 'verification-link-sent');
        }

        // Send notification to current email
        Mail::to($user->email)->send(new ProfileUpdatedMail($user));

        return Redirect::route('profile.edit')
            ->with('success', 'Profile updated successfully!')
            ->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Store user information before deletion
        $userName = $user->name;
        $userEmail = $user->email;

        // Send account deletion confirmation email
        Mail::to($userEmail)->send(new AccountDeletedMail($userName, $userEmail));

        // Logout user
        Auth::logout();

        // Delete the account
        $user->delete();

        // Invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to login with success message in URL
        return Redirect::to('/login?deleted=1')
            ->with('status', 'account-deleted');
    }
}
