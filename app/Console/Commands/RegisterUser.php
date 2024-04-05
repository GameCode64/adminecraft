<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class RegisterUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'register-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register a new user trhough the CLI';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       $this->RegisterUser();
       if($this->confirm("Do you want to add another user?", true))
       {
            $this->handle();
       }
       return;
    }

    private function RegisterUser()
    {
        $Username = $this->ask("New username");
        $Password = $this->secret("New password (Leave empty to generate). Input is not visible");
        $GennedPasssword = empty($Password) ? Str::random(24) : null;
        $Password = (empty($Password) ?  hash("sha512", $GennedPasssword) :  hash("sha512", $Password));
        $Email = $this->ask("New Emailaddress");
        $Admin = $this->confirm("Is this user a admin user?", false);
        if($this->confirm("Are you sure you want to create this user?", true))
        {
            User::create([
                "name" => $Username,
                "password" => $Password,
                "email" => $Email,
                "Authority" => $Admin ? 2 : 1,
                "email_verified_at",
                "GameName" => $Username
            ]);
        }
        $this->info("User has been added!");
        $this->line("Username: \"$Username\"");
        $this->line( is_null($GennedPasssword) ? "Password: **Hidden**" : "Password: \"$GennedPasssword\"");
        $this->line("Email: \"$Email\"");
    }
}
