<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerificationOtpNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $otp
    ) {
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Kode OTP Verifikasi Email')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Gunakan kode OTP berikut untuk memverifikasi alamat email Anda:')
            ->line('**' . $this->otp . '**')
            ->line('Kode OTP ini berlaku selama 5 menit.')
            ->line('Jika Anda tidak melakukan pendaftaran, abaikan email ini.');
    }
}