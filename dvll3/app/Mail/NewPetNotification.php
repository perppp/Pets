<?php

namespace App\Mail;

use App\Models\Pet;
use Illuminate\Mail\Mailable;

class NewPetNotification extends Mailable
{
    public $pet;

    public function __construct(Pet $pet)
    {
        $this->pet = $pet;
    }

    public function build()
    {
        return $this->subject('New Pet Available for Adoption')
                    ->view('emails.new_pet');
    }
}