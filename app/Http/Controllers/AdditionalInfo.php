<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;

class AdditionalInfo extends Controller
{
    public static function GetAdditionalInfo()
    {
        
        return array(
            "ServerTitle" => Settings::where([["Key", "=", "ServerTitle"]])->first()["Value"],
            "PanelVersion" => "0.9.1"
        );
    }
}
