<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Emailing extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($props, $email, $operator, $date)
    {
        //
        $this->props = $props;
        $this->email = $email;
        $this->operator = $operator;
        $this->date = $date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if(!$this->operator){
        return $this->from('hai@email.com')->view("email")->with([
            'name' => $this->props->name,
            'content' => $this->email->isi_email
        ]);

    } else if($this->email && $this->operator) {
        return $this->from('hai@email.com')->view("monthlyMessage")->with([
            'name' => $this->props->name,
        ]);
    } else {
        return $this->from("pap@email.com")->view("notification")->with([
            'name' => $this->props->name,
            'date' => $this->date,
        ]);
    }
    }
}
