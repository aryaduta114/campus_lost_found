<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportMatchNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Report $report,
        public Report $matchedReport,
        public int $score
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
            ->subject('Ditemukan Kecocokan Laporan')
            ->line(
                'Sistem menemukan kemungkinan kecocokan dengan laporan "' .
                $this->matchedReport->title .
                '".'
            )
            ->line(
                'Tingkat kecocokan: ' . $this->score . '%'
            )
            ->action(
                'Lihat Laporan',
                route('reports.show', $this->matchedReport)
            )
            ->line(
                'Silakan periksa laporan tersebut untuk memastikan apakah barangnya cocok.'
            )
            ->line(
                'Terima kasih telah menggunakan sistem Campus Lost & Found.'
            );
    }

    public function toArray(object $notifiable): array
    {
        return [
            'report_id' => $this->report->id,
            'matched_report_id' => $this->matchedReport->id,
            'score' => $this->score,
        ];
    }
}