<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeleteAllOTP extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'otp:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all OTP code from users table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \App\Models\User::where('otp_code', '!=', null)->update(['otp_code' => null]);

        Log::info('OTP code deleted successfully.');
        $this->info('OTP code deleted successfully');

        // return Command::SUCCESS;
    }
}
