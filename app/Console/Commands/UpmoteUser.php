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
    protected $signature = 'user:upmote';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elevates a user to admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $Users = User::where([["Authority", "=", "1"]])->get("name")->toArray();
        $this->line(sprintf("There are %s users not admin:", count($Users)));
        $Userlist = array();
        foreach ($Users as $User) {
            $this->line(" - " . $User["name"]);
            $Userlist[] = $User["name"];
        }
        $SelectedUser = ($this->anticipate("Which account do you want to elevate? (Case-Sensitive)", $Userlist));
        dd(User::where([["name", "=", "$SelectedUser"]])->update(["Authority" => 2]));
    }
}
