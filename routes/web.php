<?php

use App\Http\Controllers\AsyncController;
use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use App\Http\Middleware\Login;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (!(new LoginController)->IsLoggedIn())
        return redirect("/login");

    return view('body/dashboard', [
        "Route" => "dashboard",
    ]);
});

Route::get('/console', function () {
    if (!(new LoginController)->IsLoggedIn())
        return redirect("/login");

    return view('body/console', [
        "Route" => "console",
        "Log" => AsyncController::GetInitialLog(),
    ]);
});

Route::get('/console/log', function () {
    if (!(new LoginController)->IsLoggedIn())
        return redirect("/login");

    return AsyncController::GetLive();
})->name("console.log");

Route::get('/filemanager', function () {
    if (!(new LoginController)->IsLoggedIn())
        return redirect("/login");

    return view('body/filemanager', [
        "Route" => "filemanager",
    ]);
});

Route::get('/logs', function () {
    if (!(new LoginController)->IsLoggedIn())
        return redirect("/login");

    return view('body/logs', [
        "Route" => "logs",
    ]);
});

Route::get('/users', function () {
    if (!(new LoginController)->IsLoggedIn())
        return redirect("/login");

    return view('body/users', [
        "Route" => "users",
    ]);
});

Route::get('/myaccount', function () {
    if (!(new LoginController)->IsLoggedIn())
        return redirect("/login");

    return view('body/myaccount', [
        "Route" => "myaccount",
    ]);
});

Route::get('/login', function () {
    return view("login");
})->name("login");

Route::get('/logout', function () {
    (new LoginController)->Logout();
    return redirect("/");
});

Route::post('/login', function (Request $Request) {
    return (new LoginController)->Login($Request);
});
