<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function editProfile()
    {
        $user = Auth::user();

        return view('auth.edit-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => ['confirmed',  Password::defaults()]
        ]);

        $input = $request->all();

        if($request->has('password') && $request->password != '') {
            $input['password'] = Hash::make($request->password);
        }

        $user = Auth::user();
        $user->fill($input);
        $user->save();

        return redirect()->route('home');
    }
}
