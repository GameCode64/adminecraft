<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function Login(Request $request) //: RedirectResponse
    {
        if (($request->session()->get("Name")) == null) {
            $CheckUser = User::where([["email", "=", $request["email"]], ["password", "=", hash("sha512", $request["password"])]])->first();
            if ($CheckUser != null) {
                if ($CheckUser["Authority"] > 0)
                {
                    $request->session()->put([
                        "Name" => $CheckUser["name"],
                        "GameName" => $CheckUser["GameName"],
                        "Email" => $CheckUser["email"],
                        "Authority" => $CheckUser["Authority"],
                    ]);
                    return array("Status"=> true, "Action"=>redirect()->intended());
                }
                return array("Status"=>false, "Message"=>"Account hasn't been verified yet!");
            }
            return array("Status"=>false, "Message"=>"Login credentials are incorrent or not existing!");
        }
    }

    public function IsLoggedIn()
    {

        return !Session::get("Name") == null;
    }

    public function Logout()
    {
        Session::flush();
    }

    public function Register(Request $request)
    {
        if (isset($request["email"],$request["password"],$request["confpassword"],$request["username"]))
        {
            if ($request["password"] === $request["confpassword"])
            {
                $CheckUser = User::where([["email", "=", $request["email"]]])->orwhere([["name", "=", $request["username"]]])->first();
                if ($CheckUser != null) {
                    return array("Items" => [$request["email"],$request["password"],$request["confpassword"],$request["username"]], "Status" => false, "Message" => "Account already exist for this email or username!");
                }
                User::create([
                    "email" => $request["email"],
                    "password" => hash("sha512", $request["password"]),
                    "name" => $request["username"],
                    "GameName" => $request["username"],
                    "Authority" => 0,
                    "registerToken" => Str::random(100),
                ]);
                return array( "Status" => true, "Message" => "Account has been created succesfully, please check your e-mail for the validation.");
            }
            return array("Items" => [$request["email"],$request["password"],$request["confpassword"],$request["username"]], "Status" => false, "Message" => "Passwords does not match!");
        }
        return array("Items" => [$request["email"],$request["password"],$request["confpassword"],$request["username"]], "Status" => false, "Message" => "You might missing a field!");
    }

    public function Verify(Request $request)
    {
        if (isset($request["username"],$request["verifytoken"]))
        {
            $CheckUser = User::where([["name", "=", $request["username"]], ["registerToken", "=", $request["verifytoken"]], ["updated_at", ">", date("Y-m-d H:i:s", strtotime("-4 hours"))]])->first();
            if ($CheckUser != null)
            {
                $CheckUser->registerToken = null;
                $CheckUser->Authority = 1;
                $CheckUser->email_verified_at = date("Y-m-d H:i:s");
                $CheckUser->save();
                return array("Status"=> true, "Message"=>"Your account has been verified!", "Action"=>redirect("/login"));
            }
            $CheckUser = User::where([["name", "=", $request["username"]], ["registerToken", "=", $request["verifytoken"]], ["updated_at", "<", date("Y-m-d H:i:s", strtotime("-4 hours"))]])->first();
            if ($CheckUser != null)
            {
                //generating new token because the token has been expired
                $CheckUser->registerToken = Str::random(100);
                $CheckUser->save();
            }

        }
        return array("Status"=>false, "Message"=>"Login credentials are incorrent or not existing!");

    }

    public function IsAdmin()
    {
        return Session::get("Authority") >= 2 ;
    }
}
