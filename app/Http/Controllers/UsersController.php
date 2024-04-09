<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(isset($request["data"]))
        {
            if($request["data"]["UserID"] == 0)
            {
                User::create([
                    "name" => $request["data"]["name"],
                    "password" => hash("sha512", $request["data"]["Password"]),
                    "email" => $request["data"]["email"],
                    "Authority" => Session::get("Authority") >= $request["data"]["Authority"] ? $request["data"]["Authority"] : 0,
                    "email_verified_at" => date("Y-m-d H:i:s"),
                    "GameName" => $request["data"]["GameName"]
                ]);
                return array("Status" => true, "Message" => "The user has been created");
            }
            else
            {
              User::where([["id", "=", $request["data"]["UserID"]]])->update([
                    "name" => $request["data"]["name"],
                    "email" => $request["data"]["email"],
                    "Authority" => Session::get("Authority") >= $request["data"]["Authority"] ? $request["data"]["Authority"] : 0,
                    "GameName" => $request["data"]["GameName"]
                ]);
                return array("Status" => true, "Message" => "The user has been editted");
            }
        }
    }

    public function delete(Request $request)
    {
        if(Session::get("UserID") != $request["UserID"]  )
        {
            User::where([["id", "=", $request["UserID"]]])->delete();
            return array("Status" => true, "Message" => "The user has been deleted");
        }
        return array("Status" => false, "Message" => "You can't delete your self");
    }

}
