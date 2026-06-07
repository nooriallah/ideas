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




    public function edit()
    {
        return view("auth.edit");
    }

    public function update(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users,email," . Auth::id(),
            "password" => "nullable|string|min:3"
        ]);

        $updatedAttr = [
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password ? bcrypt($request->password) : Auth::user()->password
        ];

        Auth::user()->update($updatedAttr);

        return redirect()->route("auth.edit")->with("success", "Profile updated successfully");
    }



    public function destroy()
    {
        Auth::logout();
        return redirect("/");
    }
}
