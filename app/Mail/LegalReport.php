<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LegalReport extends Mailable
{
    use Queueable, SerializesModels;

    private $filepath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($filepath = null)
    {
        $this->filepath = $filepath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->filepath !== null) {
            return $this->view('legal.legalreport')
                ->attach(storage_path("app/legal/$this->filepath"), [
                    'as' => $this->filepath,
                    'mime' => 'application/gzip',
                ]);
        } else {
            return $this->view('legal.legalreport');
        }
    }
}
