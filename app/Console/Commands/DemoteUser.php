<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class DemoteUser extends Command
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
        $SelectedUser = ($this->anticipate("Which account do you want to revoke from admin rights? (Case-Sensitive)", $Userlist));
        dd(User::where([["name","=","$SelectedUser"]])->update(["Authority" => 1]));
    }
}
