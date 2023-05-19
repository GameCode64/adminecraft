<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class LogController extends Controller
{
    public function GetLogs()
    {
        $Files = (File::allFiles(Settings::where([["Key", "=", "MCLocation"]])->first()["Value"] . "/logs/"));
        return collect($Files)->transform(function ($Name) {
            return basename($Name);
        })->all();
    }

    public function GetLog(Request $request)
    {
        if (isset($request["File"])) {
            $File = Settings::where([["Key", "=", "MCLocation"]])->first()["Value"] . "/logs/$request[File]";
            if (File::exists("$File")) {
                if (File::extension($File) == "log") {
                    return File::get($File);
                } else if (File::extension($File) == "gz") {
                    return implode("", gzfile($File));
                }
                return null;
            }
        }
        return null;
    }
}
