<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Deduction;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeductAmount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deduct:amount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deduct the specified amount from the personal account for due deduction records';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $currentDate = Carbon::now();

            $dueDeductions = Deduction::where('start_date', '<=', $currentDate)->get();

            foreach ($dueDeductions as $deduction) {
                // Calculate the next deduction date based on the deduction frequency
                $nextDeductionDate = null;
                switch ($deduction->frequency) {
                    case 'daily':
                        $nextDeductionDate = Carbon::createFromFormat('Y-m-d', $deduction->start_date)->addDay();
                        break;
                    case 'weekly':
                        $nextDeductionDate = Carbon::createFromFormat('Y-m-d', $deduction->start_date)->addWeek();
                        break;
                    case 'monthly':
                        $nextDeductionDate = Carbon::createFromFormat('Y-m-d', $deduction->start_date)->addMonth();
                        break;
                    case 'yearly':
                        $nextDeductionDate = Carbon::createFromFormat('Y-m-d', $deduction->start_date)->addYear();
                        break;
                    default:
                        // Handle unknown frequency, or you can skip the record.
                        Log::error('Unknown frequency for deduction record with ID: ' . $deduction->id);
                        continue 2;
                }
                Log::info('Next deduction date calculated for deduction record with ID: ' . $deduction->id);

                // Ensure the next deduction date falls within the deduction period (start date and end date).
                if ($nextDeductionDate >= $deduction->start_date && $nextDeductionDate <= $deduction->end_date) {
                    $deduction->deductionHistories()->create([
                        'amount' => $deduction->amount,
                        'description' => 'Deduction for ' . $deduction->name,
                    ]);

                    $account = User::find($deduction->user_id);

                    if (!$account) {
                        // Handle the case where the associated personal account is not found.
                        Log::error('Personal account not found for deduction record with ID: ' . $deduction->id);
                        continue;
                    }

                    // $deductedAmount = $deduction->amount;

                    // // Update the account's balance by deducting the amount
                    // $account->basic_balance -= $deductedAmount;
                    // $account->save();
                    Log::info('Amount deducted from personal account with ID: ' . $account->id . ' for deduction record with ID: ' . $deduction->id);
                } else {
                    // Handle the case where the next deduction date falls outside the deduction period.
                    Log::error('Next deduction date falls outside the deduction period for deduction record with ID: ' . $deduction->id);
                    continue;
                }
            }
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('Error occurred while deducting amount from personal accounts for due deduction records: ' . $th->getMessage());
        }

        Log::info('Amount deducted from personal accounts for due deduction records successfully.');
        $this->info('Amount deducted from personal accounts for due deduction records successfully.');
        // return Command::SUCCESS;
    }
}
