<?php

use App\Http\Controllers\IdeaController;
use App\Http\Controllers\RegisterdUserContorller;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\StepController;
use Illuminate\Support\Facades\Route;

Route::redirect("/", "/ideas");
Route::get("/ideas", [IdeaController::class, "index"])->name("idea.index")->middleware("auth");
Route::get("ideas/{idea}", [IdeaController::class, "show"])->name("idea.show")->middleware("auth");
Route::delete("ideas/{idea}", [IdeaController::class, "destroy"])->name("idea.destroy")->middleware("auth");
Route::post("/ideas", [IdeaController::class, "store"])->name("idea.store")->middleware("auth");
Route::put("/ideas/{idea}", [IdeaController::class, "update"])->name("idea.update")->middleware("auth");
Route::patch("/steps/{step}", [StepController::class, "update"])->name("step.update")->middleware("auth");

Route::get("/profile/edit", [SessionsController::class, "edit"])->name("auth.edit")->middleware("auth");
Route::patch("/profile", [SessionsController::class, "update"])->name("auth.update")->middleware("auth");


Route::get("/register", [RegisterdUserContorller::class, "create"])->name("register");
Route::post("/register", [RegisterdUserContorller::class, "store"]);

Route::get("/login", [SessionsController::class, "create"])->name("login");
Route::post("/login", [SessionsController::class, "store"]);
Route::get("/logout", [SessionsController::class, "destroy"]);
