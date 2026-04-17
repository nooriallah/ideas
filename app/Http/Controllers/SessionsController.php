<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function create()
    {
        return view("auth.login");
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            "email" => "required|email",
            "password" => "required|min:3"
        ]);

        if (!Auth::attempt($attributes)) {
            return back()
                ->withErrors(["password" => "Incorrect username or password"])
                ->withInput();
        }

        $request->session()->regenerate();

        return redirect()->intended("/");
    }

    public function destroy()
    {
        Auth::logout();
        return redirect("/");
    }
}
