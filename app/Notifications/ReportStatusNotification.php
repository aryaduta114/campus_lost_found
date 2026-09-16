<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportStatusNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Report $report,
        public string $status
    ) {
        //
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Status Laporan Berubah')
            ->line('Laporan "' . $this->report->title . '" telah diperbarui.')
            ->line('Status laporan sekarang: ' . $this->status)
            ->action(
                'Lihat Laporan',
                route('reports.show', $this->report)
            )
            ->line('Terima kasih telah menggunakan sistem Campus Lost & Found.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'report_id' => $this->report->id,
            'status' => $this->status,
        ];
    }
}