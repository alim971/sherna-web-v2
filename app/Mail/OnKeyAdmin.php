<?php

namespace App\Mail;

use App\Reservation;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OnKeyAdmin extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * Emailová adresa uživatele.
     *
     * @var User|null
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
     * @param User $user
     * @param Reservation $reservation
     */
    public function __construct(User $user, Reservation $reservation)
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
        return $this->markdown('emails.onkey-admin', [
            'user' => $this->user, 'reservation' => $this->reservation
        ])->subject('VR Request')->from(env('email'));
    }
}
