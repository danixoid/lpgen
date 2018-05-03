<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewClaim extends Mailable
{
    use Queueable, SerializesModels;

    private $request = [];
    public $send_to = null;
    public $type = '';
    public $root = null;

    /**
     * Create a new message instance.
     *
     * @param String $to
     * @param $type
     * @param Request $request
     */
    public function __construct($to, $type, Request $request)
    {
        $this->send_to = $to;
        $this->type = $type;
        $this->request = $request->all();
        $this->root = $request->root();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->to($this->send_to)
            ->subject('Новая заявка')
            ->from("admin@" . env('LPGEN_KZ','b-apps.kz'),
                'Администратор "' . $this->root . '"')
            ->view('mail.new_claim',['request' => $this->request,'type' => $this->type, 'root' => $this->root ]);
    }
}
