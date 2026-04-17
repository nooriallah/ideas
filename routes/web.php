<?php

use App\Http\Controllers\RegisterdUserContorller;
use App\Http\Controllers\SessionsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get("/register", [RegisterdUserContorller::class, "create"]);
Route::post("/register", [RegisterdUserContorller::class, "store"]);

Route::get("/login", [SessionsController::class, "create"]);
Route::post("/login", [SessionsController::class, "store"]);
Route::get("/logout", [SessionsController::class, "destroy"]);
