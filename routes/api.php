<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CategoriesController;
use App\Http\Middleware\ApiAuthMiddleware;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\EnsureItsAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);

Route::middleware(ApiAuthMiddleware::class)->group(function() {
    Route::post("/logout", [AuthController::class, "logout"]);
    Route::post("/profile", [AuthController::class, "profile"]);
    
    Route::middleware(EnsureItsAdmin::class)->prefix("admin")->group(function() {
        Route::post("/categories", [CategoriesController::class, "store"]);
        Route::get("/categories", [CategoriesController::class, "index"]);
        Route::put("/categories/{id}", [CategoriesController::class, "update"]);
        Route::delete("/categories/ {id}", [CategoriesController::class, "delete"]);

        Route::prefix("cars")->group(function () {
            Route::post("/", [CarController::class, "store"]); 
            Route::get("/{id}", [CarController::class, "detail"]); 
            Route::put("/{id}", [CarController::class, "update"]); 
            Route::delete("/{id}", [CarController::class, "destroy"]);
        });
    });

    Route::get("/", [CarController::class, "index"]); 
});     