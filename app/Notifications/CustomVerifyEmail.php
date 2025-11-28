<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends VerifyEmail
{
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Vérification de votre adresse email')
            ->greeting('Bonjour !')  // Remplace "Hello!"
            ->line('Veuillez cliquer sur le bouton ci-dessous pour vérifier votre adresse email.')  // Remplace "Please click..."
            ->action('Vérifier l\'adresse email', $verificationUrl)  // Remplace "Verify Email Address"
            ->line('Si vous n\'avez pas créé de compte, aucune action n\'est requise.')  // Remplace "If you did not create..."
            ->salutation('Cordialement,
Laravel');  // Remplace "Regards, Laravel"
    }
}