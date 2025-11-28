<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function index(){
        return view('User.user');
    }

    public function edit(Request $request)
    {
        if ($request->session()->has('admin_id')) {
            $user = Admin::find($request->session()->get('admin_id'));
            if (!$user) {
                abort(404, 'Admin not found');
            }

            // Add a virtual property 'name' for Blade
            $user->name = $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name;
        } else {
            $user = Auth::user();
        }

        return view('profile.edit', compact('user'));
    }



public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'contact_number' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'current_password' => 'nullable|string',
        'new_password' => 'nullable|min:8|confirmed', // validates new_password & new_password_confirmation
    ]);

    // ✅ Update user info
    $user->update([
        'first_name' => $request->first_name,
        'middle_name' => $request->middle_name,
        'last_name' => $request->last_name,
        'contact_number' => $request->contact_number,
        'address' => $request->address,
        'email' => $request->email,
    ]);

    // ✅ Handle image upload
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $path = $image->storeAs('profiles', $imageName, 'public');
        $user->image = $path;
        $user->save();
    }

    // ✅ Handle password change
    if ($request->filled('current_password') || $request->filled('new_password')) {
        if (!Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'The current password is incorrect.'])
                ->withInput();
        }

        if ($request->new_password !== $request->new_password_confirmation) {
            return back()
                ->withErrors(['new_password' => 'New password and confirmation do not match.'])
                ->withInput();
        }

        $user->password = Hash::make($request->new_password);
        $user->save();
    }

    return back()->with('status', 'Profile updated successfully!');
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

    public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $admin = Admin::find($request->session()->get('admin_id'));
    if (!$admin) {
        return back()->withErrors(['current_password' => 'Admin not found']);
    }

    // Temporary bypass for plain-text passwords
    // If your current password matches the plain-text
    if ($request->current_password !== $admin->password) {
        return back()->withErrors(['current_password' => 'Current password is incorrect']);
    }

    // Save new password hashed
    $admin->password = $request->password; // Mutator will hash it
    $admin->save();

    return back()->with('status', 'password-updated');
}


}
