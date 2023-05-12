<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Modules\RCON\RCON;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class AsyncController extends Controller
{
    public static function SendCommand($Command)
    {
        
       // File::append(Settings::where([["Key","=", "MCLocation"] ])->first()["Value"]."/logs/latest.log", "[WEB] $Command");
        
        $RCON = (new RCON("test"))
        ->Connect();
        
        $Resp = $RCON->SendCommand($Command);
        return $Resp;
    }

 


    public static function GetInitialLog()
    {
        return htmlentities(file_get_contents(Settings::where([["Key","=", "MCLocation"] ])->first()["Value"]."/logs/latest.log"));
    }

    public static function GetLive(int $MaxLogSize = 300)
    {
        //$LineCount = 600;
        $Lines = explode(PHP_EOL, File::get(Settings::where([["Key","=", "MCLocation"] ])->first()["Value"]."/logs/latest.log"));
        $LogLines = $MaxLogSize == 0 ? $Lines : array_slice($Lines, -(min($MaxLogSize, count($Lines))));
        return (response()->make(htmlentities(implode(PHP_EOL, $LogLines))));
    }
}