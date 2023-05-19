<?php

namespace App\Modules\Minecraft;

use App\Models\Settings;
use App\Modules\RCON\RCON;
use Exception;

class Minecraft
{

    public static function WhitelistUser($Username)
    {
        if(Settings::where([["Key", "=", "AutoWhitelist"]])->first()["Value"]){
            try{
                $RCON = new RCON();
                $RCON->SetPass(Settings::where([["Key", "=", "RconPass"]])->first()["Value"]);
                $RCON->SetHost(Settings::where([["Key", "=", "RconServer"]])->first()["Value"]);
                $RCON->SetPort(Settings::where([["Key", "=", "RconPort"]])->first()["Value"]);
                $RCON->connect();
                $RCON->SendCommand("whitelist add $Username");
            }
            catch(\Exception)
            {

            }
        }
    }
}