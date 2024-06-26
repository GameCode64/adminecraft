<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\User;
use App\Modules\Minecraft\Minecraft;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Mail;
use App\Mail\Verify;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function Login(Request $request) //: RedirectResponse
    {
        if (!isset($request["email"], $request["password"]) || (empty($request["email"]) && empty($request["password"]))) {
            return array("Status" => false, "Message" => "Login credentials are incorrent or not existing!");
        }

        $Recaptcha = $this->ValidateRecaptcha($request);
        if (!$Recaptcha["Status"])
            return $Recaptcha;

        if (($request->session()->get("Name")) == null) {
            $CheckUser = User::where([["email", "=", $request["email"]], ["password", "=", hash("sha512", $request["password"])]])->first();
            if ($CheckUser != null) {
                if ($CheckUser["Authority"] > 0) {
                    $request->session()->put([
                        "UserID" => $CheckUser["id"],
                        "Name" => $CheckUser["name"],
                        "GameName" => $CheckUser["GameName"],
                        "Email" => $CheckUser["email"],
                        "Authority" => $CheckUser["Authority"],
                    ]);
                    return array("Status" => true, "Action" => redirect()->intended());
                }
                return array("Status" => false, "Message" => "Account hasn't been verified yet!");
            }
            return array("Status" => false, "Message" => "Login credentials are incorrent or not existing!");
        }
    }

    public function IsLoggedIn()
    {

        return !Session::get("Name") == null;
    }

    private function ValidateRecaptcha(Request $request)
    {
        if (!isset($request["g-recaptcha-response"]) || empty($request["g-recaptcha-response"])) {
            return array("Status" => false, "Message" => "Recaptcha validation token is missing!");
        }

        $RecaptchaResponse = Http::asForm()->withoutVerifying()->post("https://www.google.com/recaptcha/api/siteverify", [
            "secret" => $_ENV["RECAPTCHA_SECRET_KEY"],
            "response" => $request["g-recaptcha-response"],
            "remoteip" => $_SERVER["REMOTE_ADDR"]
        ]);
        $RecaptchaResponse = $RecaptchaResponse->object();

        if (!$RecaptchaResponse->success || $RecaptchaResponse->score <= 0.5) {
            return array("Status" => false, "Message" => "Recaptcha validation failed, please try again!");
        }
        return array("Status" => true);
    }

    public function Logout()
    {
        Session::flush();
    }

    public function Register(Request $request)
    {
        if (isset($request["email"], $request["password"], $request["confpassword"], $request["username"])) {

            $Recaptcha = $this->ValidateRecaptcha($request);
            if (!$Recaptcha["Status"])
                return $Recaptcha;

            if ($request["password"] === $request["confpassword"]) {
                $CheckUser = User::where([["email", "=", $request["email"]]])->orwhere([["name", "=", $request["username"]]])->first();
                if ($CheckUser != null) {
                    return array("Items" => [$request["email"], $request["password"], $request["confpassword"], $request["username"]], "Status" => false, "Message" => "Account already exist for this email or username!");
                }
                $Token = Str::random(100);
                User::create([
                    "email" => $request["email"],
                    "password" => hash("sha512", $request["password"]),
                    "name" => $request["username"],
                    "GameName" => $request["username"],
                    "Authority" => 0,
                    "registerToken" => $Token,
                ]);
                //dump(!boolval(Settings::where([["Key", "=", "ManualVerify"]])->first()["Value"]));
                if (!boolval(Settings::where([["Key", "=", "ManualVerify"]])->first()["Value"])) {
                    // Mail::to($request["email"])->send(new Verify(["Username" => $request["username"], "Token"=> $Token]));
                    return array("Status" => true, "Message" => "Account has been created succesfully, please check your e-mail for the validation.");
                }
                return array("Status" => true, "Message" => "Account has been created succesfully, please wait untill a admin verifies your registration.");
            }
            return array("Items" => [$request["email"], $request["password"], $request["confpassword"], $request["username"]], "Status" => false, "Message" => "Passwords does not match!");
        }
        return array("Items" => [$request["email"], $request["password"], $request["confpassword"], $request["username"]], "Status" => false, "Message" => "You might missing a field!");
    }

    public function Verify(Request $request)
    {
        if (!boolval(Settings::where([["Key", "=", "ManualVerify"]])->first()["Value"])) {
            if (isset($request["username"], $request["verifytoken"])) {
                $CheckUser = User::where([["name", "=", $request["username"]], ["registerToken", "=", $request["verifytoken"]], ["updated_at", ">", date("Y-m-d H:i:s", strtotime("-4 hours"))]])->first();
                if ($CheckUser != null) {
                    $CheckUser->registerToken = null;
                    $CheckUser->Authority = 1;
                    $CheckUser->email_verified_at = date("Y-m-d H:i:s");
                    $CheckUser->save();
                    Minecraft::WhitelistUser($CheckUser->name);
                    return array("Status" => true, "Message" => "Your account has been verified!", "Action" => redirect("/login"));
                }
                $CheckUser = User::where([["name", "=", $request["username"]], ["registerToken", "=", $request["verifytoken"]], ["updated_at", "<", date("Y-m-d H:i:s", strtotime("-4 hours"))]])->first();
                if ($CheckUser != null) {
                    //generating new token because the token has been expired
                    $NewToken = Str::random(100);
                    $CheckUser->registerToken = $NewToken;
                    // Mail::to($CheckUser->email)->send(new Verify(["Username" => $request["username"], "Token"=> $NewToken]));
                    $CheckUser->save();
                }
            }
        }
        return array("Status" => false, "Message" => "Login credentials are incorrent or not existing!");
    }

    public function IsAdmin()
    {
        return Session::get("Authority") >= 2;
    }
}
