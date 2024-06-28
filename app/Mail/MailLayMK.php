<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailLayMK extends Mailable
{
    use Queueable, SerializesModels;
    protected $content;
    protected $model_user;
    public $details;
    /**
     * Create a new message instance.
     */
    public function __construct($details)
    {
        // $this->content=$content;
        // $this->model_user=$model_user;
        $this->details = $details;

    }


    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function build()
    {
        return $this->subject('Reset mật khẩu')
                    ->view('Mail.maillaymk')
                    ->with('details', $this->details);
    }
}
