<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::paginate(10);
        return view('users', compact('users'));
    }

    public function activate(User $user)
    {
        $user->update(['status' => 1]);
        return redirect()->back()->with('success', 'User activated successfully');
    }

    public function deactivate(User $user)
    {
        $user->update(['status' => 0]);
        return redirect()->back()->with('success', 'User deactivated successfully');
    }
}
