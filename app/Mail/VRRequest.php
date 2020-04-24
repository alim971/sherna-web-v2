<?php

namespace App\Mail;

use App\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VRRequest extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * Emailová adresa uživatele.
     *
     * @var string|null
     */
    protected $user;
    /**
     * Obsah emailové zprávy.
     *
     * @var Reservation
     */
    protected $reservation;

    /**
     * Vytvoř novou instanci emailové zprávy.
     *
     * @param string $user
     * @param Reservation $reservation
     */
    public function __construct($user, Reservation $reservation)
    {
        $this->user = $user;
        $this->reservation = $reservation;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.vr', [
            'user' => $this->user, 'reservation' => $this->reservation
        ])->subject('VR Request')->from($this->user->email);
    }
}
