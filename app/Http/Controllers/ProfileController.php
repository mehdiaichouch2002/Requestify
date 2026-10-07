<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    private const PUBLIC_PATH  = 'public/photos/';
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
        $old_avatar = $request->user()->avatar;

        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        if($request->hasFile('avatar')){
            $nomPhoto = $request->avatar->hashName();

            $request->avatar->storeAs(self::PUBLIC_PATH, $nomPhoto);
            if ($old_avatar){
                Storage::delete(self::PUBLIC_PATH. $old_avatar);

            }
        }
        else {
            $nomPhoto = $request->user()->avatar;
        }
        $request->user()->avatar = $nomPhoto;
        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'Profile Updated Successfully!');
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

        // The super admin is the only account that can't be recreated from the app
        if ($user->isSuperAdmin()) {
            return back()->withErrors(['password' => __('The super admin account cannot be deleted.')], 'userDeletion');
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
