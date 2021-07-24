<?php

namespace App\Console\Commands;

use App\Models\Order;
use Pusher\Pusher;
use Illuminate\Console\Command;

class SendNotifyOrderIsPendingForAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification for admin about notification not confirm yet';

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
        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $count_order_pending = Order::where('status', config('app.status_order.pending'))->count();

        $pusher->trigger('SendNotifyOrderIsPendingForAdminEvent', 'send-notification-order-pending', [
            'message' =>  trans('notification.mess_noti_pending_order', ['count' => $count_order_pending]),
        ]);
    }
}
