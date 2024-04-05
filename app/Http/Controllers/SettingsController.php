<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class SettingsController extends Controller
{
    public function GetControlPanelFunctions()
    {
        return Settings::all("Key", "Value");
    }

    public function GetServerPropertiesFunctions()
    {
       
        try {
            return array("Status" => true, "Contents" => collect(explode(PHP_EOL, File::get(Settings::where([["Key", "=", "MCLocation"]])->first()["Value"] . "/server.properties")))->transform(function ($Line) {
                if (str_starts_with($Line, "#") || $Line === "") {
                    unset($Line);
                    return;
                }
                $O = explode("=", $Line);
                return array("Key" => $O[0], "Value" => $O[1]);
            })->all());
        } catch (\Exception) {
            return array("Status" => false, "Contents" => null);
        }
    }

    public function SaveSettings(Request $request)
    {
        if (!isset($_GET["submit"]))
            return null;
        if ($_GET["submit"] == "panel") {
            try {
                foreach ($request->collect() as $Key => $Req) {
                    if ($Key != "_token")
                        Settings::where([["Key", "=", $Key]])->update(["Value" => $Req]);
                }
                return "<div class=\"alert alert-success\">Control panel has been saved!</div>";
            } catch (\Exception | \Error) {
                return "<div class=\"alert alert-danger\">Failed to save control panel settings!</div>";
            }
        }
        if ($_GET["submit"] == "server") {
            try {
                $File = Settings::where([["Key", "=", "MCLocation"]])->first()["Value"] . "/server.properties";
                $FileHeader = collect(explode(PHP_EOL, File::get($File)))->take(2)->toArray();
                $NewSettings = array();
                foreach ($request->collect() as $Key => $Req) {
                    if ($Key != "_token" && $Key != "submit") {
                        $Key = str_replace("_", ".", $Key);
                        $NewSettings[] = "$Key=$Req";
                    }
                }
                $NewSettings = array_merge($FileHeader, $NewSettings);
                File::put($File, implode(PHP_EOL, $NewSettings), true);
                return "<div class=\"alert alert-success\">Server settings has been saved!</div>";
            } catch (\Exception | \Error) {
                return "<div class=\"alert alert-danger\">Failed to save server settings!</div>";
            }
        }
        return "<div class=\"alert alert-danger\">Something went wrong!</div>";
    }
}
