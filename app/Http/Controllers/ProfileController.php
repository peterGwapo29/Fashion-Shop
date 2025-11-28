<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    /**
     * Show Admin Profile
     */
    public function edit(Request $request)
{
    $adminId = $request->session()->get('admin_id');

    if (!$adminId) {
        return redirect('/admin/login')->withErrors(['error' => 'Please log in first.']);
    }

    $admin = \App\Models\Admin::find($adminId);

    if (!$admin) {
        abort(404, 'Admin not found.');
    }

    // ✅ Pass $admin properly
    return view('profileEdit', compact('admin'));
}


    /**
     * Update Admin Profile
     */
    public function update(Request $request)
    {
        $adminId = $request->session()->get('admin_id');

        if (!$adminId) {
            return redirect('/admin/login')->withErrors(['error' => 'Session expired. Please log in again.']);
        }

        $admin = Admin::find($adminId);

        if (!$admin) {
            return back()->withErrors(['error' => 'Admin not found.']);
        }

        // ✅ Validation
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'username' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        // ✅ Update fields
        $admin->first_name = $request->first_name;
        $admin->middle_name = $request->middle_name;
        $admin->last_name = $request->last_name;
        $admin->email = $request->email;
        $admin->username = $request->username;

        // ✅ Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profiles', 'public');
            $admin->image = $path;
        }

        // ✅ Handle password
        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (
                $request->current_password !== $admin->password &&
                !Hash::check($request->current_password, $admin->password)
            ) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }

            // Save as plain text (since no bcrypt)
            $admin->password = $request->new_password;
        }

        $admin->save();

        return back()->with('status', 'Profile updated successfully!');
    }

    /**
     * Delete Admin Account
     */
    public function destroy(Request $request)
    {
        $adminId = $request->session()->get('admin_id');
        $admin = Admin::find($adminId);

        if (!$admin) {
            return back()->withErrors(['error' => 'Admin not found.']);
        }

        $request->validate([
            'password' => 'required|string',
        ]);

        if (
            $request->password !== $admin->password &&
            !Hash::check($request->password, $admin->password)
        ) {
            return back()->withErrors(['password' => 'Incorrect password.']);
        }

        $admin->delete();
        $request->session()->forget(['admin_id', 'first_name']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/admin/login')->with('status', 'Account deleted successfully.');
    }
}
