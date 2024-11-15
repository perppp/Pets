<?php

namespace App\Mail;

use App\Models\Pet;
use Illuminate\Mail\Mailable;

class MaintenancePetNotification extends Mailable
{
    public $pet;

    public function __construct(Pet $pet)
    {
        $this->pet = $pet;
    }

    public function build()
    {
        return $this->subject('Maintenance Notification for Pet: ' . $this->pet->name)
                    ->view('emails.maintenance_pet');
    }
}