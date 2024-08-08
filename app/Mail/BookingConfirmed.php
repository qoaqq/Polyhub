<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Modules\Bill\Entities\Bill;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class BookingConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $bill;
    public $checkin;
    public $barcode;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($bill, $checkin, $barcode)
    {
        //
        $this->bill = $bill;
        $this->checkin = $checkin;
        $this->barcode = $barcode;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Booking Confirmed',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'mails.booking_confirmed',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }

    public function build()
    {
        return $this->view('mails.booking_confirmed')
        ->with([
            'bill' => $this->bill,
            'checkin' => $this->checkin,
            'barcode' => $this->barcode,
        ]);
    }
}
