<?php

// app/Http/Controllers/UserController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit ()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function update (Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date|before:today',
            'password' => 'nullable|string|min:6|confirmed',
            'nok_name' => 'required|string|max:255',
            'nok_address' => 'required|string|max:255',
            'nok_phone' => 'required|string|max:11',
            'nok_email' => 'nullable|email|max:255',
        ]);

        $user = Auth::user();

        $user->update([
            'firstName' => $validatedData['firstName'],
            'lastName' => $validatedData['lastName'],
            'date_of_birth' => $validatedData['date_of_birth'],
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
            'nok_name' => $validatedData['nok_name'],
            'nok_address' => $validatedData['nok_address'],
            'nok_phone' => $validatedData['nok_phone'],
            'nok_email' => $validatedData['nok_email'],
        ]);

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }

}
