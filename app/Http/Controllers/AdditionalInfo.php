<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;

class AdditionalInfo extends Controller
{
    public static function GetAdditionalInfo()
    {
        
        return array(
            "PanelVersion" => "1.0.0",
            "ServerTitle" => Settings::where([["Key", "=", "ServerTitle"]])->first()["Value"],
            "Settings" => [
                "AllowRegister" => Settings::where([["Key", "=", "AllowRegister"]])->first()["Value"],
                "AllowResetPassword" => Settings::where([["Key", "=", "AllowResetPassword"]])->first()["Value"],
            ]
        );
    }
}
