<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UpmoteUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:demote';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revokes the admin rights from a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $Users = User::all("name")->toArray();
        $Userlist = array();
        foreach($Users as $User)
        {
            $Userlist[] = $User["name"];
        }
        $SelectedUser = ($this->choice("Which account do you want to revoke from admin rights?", $Userlist));
        dd(User::where([["name","=","$SelectedUser"]])->update(["Authority" => 1]));
    }
}
