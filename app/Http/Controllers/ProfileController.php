<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
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

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateNotificationMethods(Request $request): RedirectResponse
    {
        //todo create a separate request file
        $validated = $request->validate([
            'notification_methods' => 'array|max:2',
            'notification_methods.*' => 'in:email,sms,telegram',
            'telegram_chat_id' => 'nullable|string',
        ]);

        if (count($validated['notification_methods']) > 2) {
            return redirect()->back()->with('error', 'You can select up to two notification methods.');
        }

        $user = Auth::user();

        $user->update([
            'notification_methods' => $validated['notification_methods'],
            'telegram_chat_id' => $validated['telegram_chat_id']
        ]);

        return redirect()->back()->with('success', 'Notification methods updated.');
    }
}
