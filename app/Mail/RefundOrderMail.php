<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class RefundOrderMail extends Mailable
{

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.refund')
            ->from(env('MAIL_USERNAME'))
            ->subject('Compra Cancelada')
            ->with(['data' => $this->data]);
    }
}
