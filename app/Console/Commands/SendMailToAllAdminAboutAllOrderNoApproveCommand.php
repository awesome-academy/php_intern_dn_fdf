<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\Order;
use Illuminate\Console\Command;
use App\Jobs\SendMailWhenUserCheckoutJob;
use App\Jobs\SendMailToAllAdminAboutAllOrderNoApproveYetJob;
use App\Notifications\SendMailAboutOrderPendingToAdminNotification;
use Carbon\Carbon;

class SendMailToAllAdminAboutAllOrderNoApproveCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail to all admin about infor order';

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
        $count_order_pending = Order::getAllPending()->count();
        $count_order_today = Order::getAllToday()->count();
        $count_pending_today = Order::getAllByStatusToday(config('app.status_order.pending'))->count();
        $count_done_today = Order::getAllByStatusToday(config('app.status_order.done'))->count();
        $count_cancel_today = Order::getAllByStatusToday(config('app.status_order.cancel'))->count();
        $message = trans('notification.mess_noti_pending_order', ['count' => $count_order_pending]);
        foreach (Admin::all() as $admin) {
            $admin->notify(
                new SendMailAboutOrderPendingToAdminNotification(
                    trans('notification.mess_noti_pending_order', ['count' => $count_order_pending])
                )
            );

            $job = (new SendMailToAllAdminAboutAllOrderNoApproveYetJob(
                $message,
                $admin,
                $count_order_today,
                $count_pending_today,
                $count_done_today,
                $count_cancel_today
            ));
            dispatch($job);
        }
    }
}
