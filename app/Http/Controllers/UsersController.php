<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
                    "Authority" => $request["data"]["Authority"],
                    "email_verified_at" => date("Y-m-d H:i:s"),
                    "GameName" => $request["data"]["GameName"]
                ]);
            }
            else
            {
               return array("Status" => "Update", User::where([["id", "=", $request["data"]["UserID"]]])->update([
                    "name" => $request["data"]["name"],
                    "email" => $request["data"]["email"],
                    "Authority" => $request["data"]["Authority"],
                    "GameName" => $request["data"]["GameName"]
                ]));
            }
        }
    }

}
