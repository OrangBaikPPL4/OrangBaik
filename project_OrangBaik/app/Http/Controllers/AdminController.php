<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        Alert::success('Success', 'Admin created successfully');
        return redirect()->route('admin.admins.index');
    }

    public function destroy(User $admin)
    {
        if ($admin->id === auth()->id()) {
            Alert::error('Error', 'You cannot delete your own account');
            return redirect()->route('admin.admins.index');
        }

        $admin->delete();
        Alert::success('Success', 'Admin deleted successfully');
        return redirect()->route('admin.admins.index');
    }
} 