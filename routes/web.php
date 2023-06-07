<?php

use App\Http\Controllers\AsyncController;
use App\Http\Controllers\Filebrowser;
use App\Http\Controllers\LogController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AdditionalInfo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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
        "Session" => Session::all(),
        "AdditionalInfo" => AdditionalInfo::GetAdditionalInfo(),
    ]);
});

Route::get('/console', function () {
    if (!(new LoginController)->IsLoggedIn())
        return redirect("/login");
    if (!(new LoginController)->IsAdmin())
        return redirect("/login");

    return view('body/console', [
        "Route" => "console",
        "Session" => Session::all(),
        "AdditionalInfo" => AdditionalInfo::GetAdditionalInfo(),
        "Log" => AsyncController::GetInitialLog(),
    ]);
});

Route::get('/console/log', function () {
    if (!(new LoginController)->IsLoggedIn())
        return redirect("/login");
    if (!(new LoginController)->IsAdmin())
        return redirect("/login");

    return AsyncController::GetLive();
})->name("console.log");

Route::get('/filemanager', function () {
    if (!(new LoginController)->IsLoggedIn())
        return redirect("/login");
    if (!(new LoginController)->IsAdmin())
        return redirect("/login");

    return view('body/filemanager', [
        "Route" => "filemanager",
        "Session" => Session::all(),
        "AdditionalInfo" => AdditionalInfo::GetAdditionalInfo(),
        "DirContent" => (new Filebrowser)->index(),
    ]);
});

Route::put('/filemanager', function (Request $Request) {
    if (!(new LoginController)->IsLoggedIn())
        return abort(403);
    if (!(new LoginController)->IsAdmin())
        return abort(403);
    return (new Filebrowser)->fetch($Request);
})->name("filebrowser.fetch");

Route::delete('/filemanager/commands', function (Request $Request) {
    if (!(new LoginController)->IsLoggedIn())
        return abort(403);
    if (!(new LoginController)->IsAdmin())
        return abort(403);
    return (new Filebrowser)->destroy($Request);
})->name("filebrowser.delete");

Route::patch('/filemanager/commands', function (Request $Request) {
    if (!(new LoginController)->IsLoggedIn())
        return abort(403);
    if (!(new LoginController)->IsAdmin())
        return abort(403);
    return (new Filebrowser)->rename($Request);
})->name("filebrowser.rename");

Route::post('/filemanager/commands', function (Request $Request) {
    if (!(new LoginController)->IsLoggedIn())
        return abort(403);
    if (!(new LoginController)->IsAdmin())
        return abort(403);
    return (new Filebrowser)->duplicate($Request);
})->name("filebrowser.duplicate");

Route::post('/filemanager/filecommands', function (Request $Request) {
    if (!(new LoginController)->IsLoggedIn())
        return abort(403);
    if (!(new LoginController)->IsAdmin())
        return abort(403);
    return (new Filebrowser)->uploadFiles($Request);
})->name("filebrowser.uploadFiles");

Route::get('/filemanager/editcommands', function (Request $Request) {
    if (!(new LoginController)->IsLoggedIn())
        return abort(403);
    if (!(new LoginController)->IsAdmin())
        return abort(403);
    return (new Filebrowser)->showFile($Request);
})->name("filebrowser.showFile");

Route::get('/filemanager/filecommands', function (Request $Request) {
    if (!(new LoginController)->IsLoggedIn())
        return abort(403);
    if (!(new LoginController)->IsAdmin())
        return abort(403);
    return (new Filebrowser)->downloadFile($Request);
})->name("filebrowser.downloadFile");

Route::patch('/filemanager/editcommands', function (Request $Request) {
    if (!(new LoginController)->IsLoggedIn())
        return abort(403);
    if (!(new LoginController)->IsAdmin())
        return abort(403);
    return (new Filebrowser)->saveFile($Request);
})->name("filebrowser.saveFile");

Route::get('/logs', function () {
    if (!(new LoginController)->IsLoggedIn())
        return redirect("/login");
    if (!(new LoginController)->IsAdmin())
        return redirect("/login");

    return view('body/logs', [
        "Route" => "logs",
        "Session" => Session::all(),
        "AdditionalInfo" => AdditionalInfo::GetAdditionalInfo(),
        "Logs" => (new LogController)->GetLogs(),
    ]);
});

Route::get('/logs/fetch', function (Request $Request) {
    if (!(new LoginController)->IsLoggedIn())
        return redirect("/login");
    if (!(new LoginController)->IsAdmin())
        return redirect("/login");

    return (new LogController)->GetLog($Request);
})->name("log.fetch");

Route::get('/users', function () {
    if (!(new LoginController)->IsLoggedIn())
        return redirect("/login");
    if (!(new LoginController)->IsAdmin())
        return redirect("/login");

    return view("body/index-users", [
        "Route" => "users",
        "Session" => Session::all(),
        "AdditionalInfo" => AdditionalInfo::GetAdditionalInfo(),
    ]);
});

Route::get('/myaccount', function () {
    if (!(new LoginController)->IsLoggedIn())
        return redirect("/login");

    return view('body/myaccount', [
        "Route" => "myaccount",
        "Session" => Session::all(),
        "AdditionalInfo" => AdditionalInfo::GetAdditionalInfo(),
    ]);
});

Route::get('/settings', function () {
    if (!(new LoginController)->IsLoggedIn())
        return redirect("/login");
    if (!(new LoginController)->IsAdmin())
        return redirect("/login");

    return view('body/settings', [
        "Route" => "settings",
        "Session" => Session::all(),
        "AdditionalInfo" => AdditionalInfo::GetAdditionalInfo(),
        "CSettings" => (new SettingsController)->GetControlPanelFunctions(),
        "SSettings" => (new SettingsController)->GetServerPropertiesFunctions(),
    ]);
});

Route::post('/settings', function (Request $Request) {
    if (!(new LoginController)->IsLoggedIn())
        return redirect("/login");
    if (!(new LoginController)->IsAdmin())
        return redirect("/login");

    return view('body/settings', [
        "Route" => "settings",
        "Session" => Session::all(),
        "AdditionalInfo" => AdditionalInfo::GetAdditionalInfo(),
        "Message" => (new SettingsController)->SaveSettings($Request),
        "CSettings" => (new SettingsController)->GetControlPanelFunctions(),
        "SSettings" => (new SettingsController)->GetServerPropertiesFunctions(),
    ]);
});

Route::get('/login', function () {
    if ((new LoginController)->IsLoggedIn())
        return redirect("/login");
    return view("login", [
        "AdditionalInfo" => AdditionalInfo::GetAdditionalInfo()
    ]);
})->name("login");

Route::get('/verifyregistration', function (Request $Request) {
    $Verify = (new LoginController)->Verify($Request);
    return view("login", ["ErrorMessage" => $Verify["Message"], "Status" => $Verify["Status"]]);
})->name("verify");

Route::get('/register', function () {
    return view("register", [
        "AdditionalInfo" => AdditionalInfo::GetAdditionalInfo()
    ]);
})->name("register");

Route::get('/logout', function () {
    (new LoginController)->Logout();
    return redirect("/");
});

Route::post('/login', function (Request $Request) {
    if ((new LoginController)->IsLoggedIn())
        return redirect("/");
    $Login = (new LoginController)->Login($Request);
    if ($Login["Status"]) {
        return $Login["Action"];
    } else {
        return view("login", [
            "ErrorMessage" => $Login["Message"], 
            "Status" => $Login["Status"],
            "AdditionalInfo" => AdditionalInfo::GetAdditionalInfo()
        ]);
    }
});

Route::post('/register', function (Request $Request) {
    $Register = (new LoginController)->Register($Request);
    if ($Register["Status"]) {
        return view("register", [
            "Return" => $Register,
            "AdditionalInfo" => AdditionalInfo::GetAdditionalInfo()
        ]);
    } else {
        return view("register", [
            "Return" => $Register,
            "AdditionalInfo" => AdditionalInfo::GetAdditionalInfo()
        ]);
    }
});
