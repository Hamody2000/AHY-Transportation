<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\IndividualTransaction;
use App\Models\CompanyTransaction;
use App\Models\User;
use App\Notifications\DetentionDateCarNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $user = User::first(); // Get the admin user to notify

            $today = Carbon::today()->toDateString();

            // Fetch and notify for individual transactions with car or client detention date
            $individualTransactions = IndividualTransaction::where(function ($query) use ($today) {
                $query->where('detention_date_car', $today)
                    ->orWhere('detention_date_client', $today);
            })->get();

            foreach ($individualTransactions as $transaction) {
                $user->notify(new DetentionDateCarNotification($transaction));
            }

            // Fetch and notify for company transactions with car or client detention date
            $companyTransactions = CompanyTransaction::where(function ($query) use ($today) {
                $query->where('detention_date_car', $today)
                    ->orWhere('detention_date_client', $today);
            })->get();

            foreach ($companyTransactions as $transaction) {
                $user->notify(new DetentionDateCarNotification($transaction));
            }
        })->daily();

        // Delete notifications older than yesterday
        $schedule->call(function () {
            $yesterday = Carbon::yesterday();
            DB::table('notifications')->where('created_at', '<', $yesterday)->delete();
        })->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
