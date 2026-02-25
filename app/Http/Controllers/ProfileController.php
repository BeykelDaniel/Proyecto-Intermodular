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
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // --- SUBIDA DE FOTO DE PERFIL ---
        if ($request->hasFile('perfil_foto')) {
            // Borrar antigua si existe
            if ($user->perfil_foto && $user->perfil_foto != 'perfil_default.png') {
                \Storage::disk('public')->delete(str_replace('storage/', '', $user->perfil_foto));
            }
            
            $path = $request->file('perfil_foto')->store('perfiles', 'public');
            $user->perfil_foto = 'storage/' . $path;
        }

        $user->save();

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

    public function updateFontSize(Request $request): RedirectResponse
    {
        $request->validate([
            'font_size' => 'required|integer|min:1|max:5',
        ]);

        $user = $request->user();
        $user->font_size = $request->input('font_size');
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'font-size-updated');
    }
}