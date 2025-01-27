<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Reservation;

class ReservationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $qrCode;

    public function __construct(Reservation $reservation, $qrCode)
    {
        $this->reservation = $reservation;
        $this->qrCode = $qrCode;
    }

    public function build()
    {
        return $this->view('emails.reservation')
                    ->attachData(base64_decode($this->qrCode), 'qrcode.png', [
                        'mime' => 'image/png',
                    ])
                    ->with([
                        'reservation' => $this->reservation,
                        'qrCode' => $this->qrCode,
                    ]);
    }
}
