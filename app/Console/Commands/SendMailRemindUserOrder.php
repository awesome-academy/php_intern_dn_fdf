<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Console\Command;
use App\Jobs\SendMailToUserHasNotOrderForALongTimeJob;
use App\Notifications\RemindUserALongTimeNotOrderNotification;

class SendMailRemindUserOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:remind-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail remind user has not order for a long time';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $message = trans('order.message_remind');
        $users = User::has('orders')->get();

        foreach ($users as $user) {
            if (Carbon::parse($user->orders()->latest()->first()->created_at)->addWeek() <= Carbon::today()) {
                $user->notify(new RemindUserALongTimeNotOrderNotification($message));

                $job = (new SendMailToUserHasNotOrderForALongTimeJob(
                    $user,
                    $message,
                ));
                dispatch($job);
            }
        }
    }
}
