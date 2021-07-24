<?php

namespace App\Mail;

use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailOrderPendingToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    protected $message_to_admin;
    protected $admin;
    protected $total_order_today;
    protected $total_order_pending_today;
    protected $total_order_done_today;
    protected $total_order_cancel_today;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        $message_to_admin,
        Admin $admin,
        $total_order_today,
        $total_order_pending_today,
        $total_order_done_today,
        $total_order_cancel_today
    ) {
        $this->message_to_admin = $message_to_admin;
        $this->admin = $admin;
        $this->total_order_today = $total_order_today;
        $this->total_order_pending_today = $total_order_pending_today;
        $this->total_order_done_today = $total_order_done_today;
        $this->total_order_cancel_today = $total_order_cancel_today;
    }

    /**
     * Build the message
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.mail-order-pending-admin', [
            'message_to_admin' => $this->message_to_admin,
            'admin' => $this->admin,
            'total_order_today' => $this->total_order_today,
            'total_order_pending_today' => $this->total_order_pending_today,
            'total_order_done_today' => $this->total_order_done_today,
            'total_order_cancel_today' => $this->total_order_cancel_today,
        ]);
    }
}
