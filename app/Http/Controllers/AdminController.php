<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function index()
    {
        // You may want to paginate users if there are a large number of them
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            // Authentication passed, redirect to admin dashboard
            return redirect()->intended('/admin/dashboard');
        } else {
            // Authentication failed, redirect back with errors
            return redirect()->back()->withInput($request->only('email'))->withErrors([
                'email' => 'These credentials do not match our records.',
            ]);
        }
    }

    public function activateUser(User $user)
    {
        $user->status = true;
        $user->save();
        return redirect()->back()->with('success', 'User account activated successfully.');
    }

    public function deactivateUser(User $user)
    {
        $user->status = false;
        $user->save();
        return redirect()->back()->with('success', 'User account deactivated successfully.');
    }
}
