<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Modules\RCON\RCON;

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
        while (true)
        {
            $RCON = (new RCON("tesd"))->SetPort(25575)->Connect();
            $RCON->SendCommand($this->ask("Enter Command"));
        }
        
    }
}
