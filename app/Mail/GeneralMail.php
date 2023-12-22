<?php
// DI CODE - Start
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GeneralMail extends Mailable
{
    use Queueable, SerializesModels;
	
	public $maildetails;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($maildetails)
    {
        $this->maildetails = $maildetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('view.name');
		return $this->subject($this->maildetails['subject'])->view('front.mail.general');
    }
}
// DI CODE - End