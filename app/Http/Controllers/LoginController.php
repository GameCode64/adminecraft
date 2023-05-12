<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function Login(Request $request)//: RedirectResponse
    {
        if (($request->session()->get("Name")) == null)
        {
            $CheckUser = User::where([["email", "=", $request["email"]], ["password","=", hash("sha512", $request["password"])]])->first();
            $request->session()->put([
                "Name" => $CheckUser["name"],
                "GameName" => $CheckUser["GameName"],
                "Email" => $CheckUser["email"],
                "Authority" => $CheckUser["Authority"],
            ]);
        }
        return redirect()->intended();
        
    }

    public function IsLoggedIn()
    {
        
        if (Session::get("Name") == null)
        {
            return false;
        }
        return true;

    }

    public function Logout()
    {
        Session::flush();
    }
}
