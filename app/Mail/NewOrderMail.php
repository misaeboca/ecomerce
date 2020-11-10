<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class NewOrderMail extends Mailable
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
        return $this->view('mails.newOrder')
            ->from(env('MAIL_USERNAME'))
            ->subject('Compra Realizada')
            ->with(['data' => $this->data]);
    }
}
