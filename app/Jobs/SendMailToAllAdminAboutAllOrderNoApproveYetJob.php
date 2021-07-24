<?php

namespace App\Jobs;

use App\Mail\MailOrderPendingToAdmin;
use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendMailToAllAdminAboutAllOrderNoApproveYetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;
    protected $admin;
    protected $total_order_today;
    protected $total_order_pending_today;
    protected $total_order_done_today;
    protected $total_order_cancel_today;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        $message,
        Admin $admin,
        $total_order_today,
        $total_order_pending_today,
        $total_order_done_today,
        $total_order_cancel_today
    ) {
        $this->message = $message;
        $this->admin = $admin;
        $this->total_order_today = $total_order_today;
        $this->total_order_pending_today = $total_order_pending_today;
        $this->total_order_done_today = $total_order_done_today;
        $this->total_order_cancel_today = $total_order_cancel_today;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->admin->email)
        ->send(new MailOrderPendingToAdmin(
            $this->message,
            $this->admin,
            $this->total_order_today,
            $this->total_order_pending_today,
            $this->total_order_done_today,
            $this->total_order_cancel_today
        ));
    }
}
