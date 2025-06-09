<?php

namespace App\Http\Controllers;

use App\Http\Controllers\LoginController;
use App\Models\Settings;
use App\Modules\RCON\RCON;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class AsyncController extends Controller
{
    public static function SendCommand($Command)
    {
        $RCON = (new RCON("test"))
            ->SetPass(Settings::where([["Key", "=", "RconPass"]])->first()["Value"])
            ->SetHost(Settings::where([["Key", "=", "RconServer"]])->first()["Value"])
            ->SetPort(Settings::where([["Key", "=", "RconPort"]])->first()["Value"])
            ->connect();

        $Resp = $RCON->SendCommand($Command);
        return preg_replace("/(\$|§)[a-zA-Z0-9]/", "", $Resp);
    }

    public static function ServiceControl(Request $Req)
    {
	 if($Req["server"] == "ghunsquad" && $Req["action"] == "restart")
	 {
	    $returnval = 999;
	    exec("sudo systemctl restart ghunmc", $output, $returnval);
	    return "Server is being restarted!, Code: $returnval";
	 }
	return "Invalid";
    }
    public static function GetInitialLog()
    {
        return htmlentities(file_get_contents(Settings::where([["Key", "=", "MCLocation"]])->first()["Value"] . "/logs/latest.log"));
    }

    public static function GetLive(int $MaxLogSize = 300)
    {
        //$LineCount = 600;
        $Lines = explode(PHP_EOL, File::get(Settings::where([["Key", "=", "MCLocation"]])->first()["Value"] . "/logs/latest.log"));
        $LogLines = $MaxLogSize == 0 ? $Lines : array_slice($Lines, - (min($MaxLogSize, count($Lines))));
        return (response()->make(htmlentities(implode(PHP_EOL, $LogLines))));
    }
}
