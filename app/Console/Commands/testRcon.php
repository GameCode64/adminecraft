<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Modules\RCON\RCON;
use Mail;
use App\Mail\Verify;

class testRcon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rcon:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       Mail::to("devds@outlook.com")->send(new Verify(["Username" => "Tester", "Token"=> "21341"]));
        
    }
}
