<?php

namespace App\Console\Commands;

use App\Models\user_active;
use Illuminate\Console\Command;

class TokenCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'token:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Token Command To Check User Token Time';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Token Command To Check User Token Time');
        $this->info('=======================================');
        user_active::where('expires_date', '<', date('Y-m-d H:i:s'))->get();

        // HOLD THIS CODE, FORGOT WHAT I WANT TO MAKE 
        // - Virgo

        
    }
}
