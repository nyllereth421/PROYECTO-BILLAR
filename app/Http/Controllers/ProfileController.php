<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show(Request $request): View
    {
        return view('profile.show', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
            'numerodocumento' => ['required', 'string', 'max:255'],
            'tipodocumento' => ['required', 'string'],
        ]);

        $request->user()->update([
            'name' => $request->name,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'numerodocumento' => $request->numerodocumento,
            'tipodocumento' => $request->tipodocumento,
        ]);

        return redirect()->route('profile.show')->with('success', 'Perfil actualizado correctamente.');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.show')->with('success', 'Contraseña actualizada correctamente.');
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
     * Update the user's avatar color.
     */
    public function updateAvatarColor(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar_color' => ['required', 'string', 'in:FF6B6B,4ECDC4,45B7D1,96CEB4,FFEAA7,DDA15E,BC6C25,9D84B7'],
        ]);

        $request->user()->update([
            'avatar_color' => $request->avatar_color,
        ]);

        return redirect()->route('profile.show')->with('success', 'Avatar actualizado correctamente.');
    }

    /**
     * Upload a custom avatar image.
     */
    public function uploadAvatarImage(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar_file' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'], // 5MB max
        ]);

        $user = $request->user();

        // Eliminar avatar anterior si existe
        if ($user->avatar_image && Storage::disk('public')->exists('avatars/' . $user->avatar_image)) {
            Storage::disk('public')->delete('avatars/' . $user->avatar_image);
        }

        // Guardar nuevo avatar
        $filename = 'avatar_' . $user->id . '_' . time() . '.' . $request->file('avatar_file')->getClientOriginalExtension();
        $request->file('avatar_file')->storeAs('avatars', $filename, 'public');

        $user->update([
            'avatar_image' => $filename,
        ]);

        return redirect()->route('profile.show')->with('success', 'Imagen de avatar subida correctamente.');
    }

    /**
     * Delete the user's custom avatar image.
     */
    public function deleteAvatarImage(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->avatar_image && Storage::disk('public')->exists('avatars/' . $user->avatar_image)) {
            Storage::disk('public')->delete('avatars/' . $user->avatar_image);
        }

        $user->update([
            'avatar_image' => null,
        ]);

        return redirect()->route('profile.show')->with('success', 'Imagen de avatar eliminada. Ahora se mostrará el avatar generado.');
    }
}
