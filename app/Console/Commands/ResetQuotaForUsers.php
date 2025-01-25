<?php

namespace App\Console\Commands;

use App\Models\Auth\UsersModel;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ResetQuotaForUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-quota-for-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset quotas for users based on their last reset date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        $users = UsersModel::where('last_reset', '<=', Carbon::now()->subDays(30))
        ->where('account_type' , 2)
        ->orWhereNull('last_reset')
        ->get();

        foreach ($users as $user) {
            $user->update([
                'items_added' => 0,
                'last_reset' => Carbon::now(),
            ]);
        }
        
        $this->info('Quotas reset for applicable users.');

    }
}