<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\AsyncController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/console/send-command', function (Request $Req) {

/* if (!(new LoginController)->IsLoggedIn())
	return abort(403);*/
    return AsyncController::SendCommand($Req["Command"]);
})->name("console.send");

Route::patch("/console/service", function(Request $Req) {
	return AsyncController::ServiceControl($Req);
})->name("service.control");
