<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class VerifyUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:verify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifies a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $Users = User::where([["Authority", "=", "0"]])->get("name")->toArray();
        $this->line(sprintf("There are %s users pending:", count($Users)));
        $Userlist = array();
        foreach ($Users as $User) {
            $this->line(" - " . $User["name"]);
            $Userlist[] = $User["name"];
        }
        $SelectedUser = ($this->anticipate("Which account do you want to verify? (Case-Sensitive)", $Userlist));
        dd(User::where([["name", "=", "$SelectedUser"]])->update(["Authority" => 1]));
    }
}
