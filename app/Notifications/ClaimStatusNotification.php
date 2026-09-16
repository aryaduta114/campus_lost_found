<?php

namespace App\Notifications;

use App\Models\Claim;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClaimStatusNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Claim $claim
    ) {
        //
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $status = $this->claim->status;

        $message = match ($status) {
            'APPROVED' => 'Klaim kamu telah disetujui oleh staff.',
            'REJECTED' => 'Klaim kamu telah ditolak oleh staff.',
            default => 'Status klaim kamu telah diperbarui.',
        };

        return (new MailMessage)
            ->subject('Status Klaim Berubah')
            ->line($message)
            ->line(
                'Laporan: "' . $this->claim->report->title . '"'
            )
            ->line(
                'Status klaim sekarang: ' . $status
            )
            ->action(
                'Lihat Laporan',
                route('reports.show', $this->claim->report)
            )
            ->line(
                'Terima kasih telah menggunakan sistem Campus Lost & Found.'
            );
    }

    public function toArray(object $notifiable): array
    {
        return [
            'claim_id' => $this->claim->id,
            'report_id' => $this->claim->report_id,
            'status' => $this->claim->status,
        ];
    }
}