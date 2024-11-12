<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }
    public function store()
    {
        $validatedattributes = request()->validate([

            'email' => ['required'],
            'password' => ['required'] //password_confirmation

        ]);

        if (!Auth::attempt($validatedattributes)) {
            throw ValidationException::withMessages([
                'email' => trans('Sorry, credentials do not match'),
            ]);
        }
        request()->session()->regenerate();
        return redirect('/');
    }
    public function destroy()
    {
        Auth::logout();
        return redirect('/');
    }
}
