<?php

namespace App\Services;

use App\Models\Report;
use App\Models\ReportMatch;
use App\Notifications\ReportMatchNotification;

class ReportMatchingService
{
    /**
     * Mencari laporan yang berlawanan jenis
     * dan sudah disetujui oleh staff.
     */
    public function findMatches(Report $report)
    {
        $oppositeType = $report->type === 'LOST'
            ? 'FOUND'
            : 'LOST';

        $candidates = Report::query()
            ->where('type', $oppositeType)
            ->where('status', 'APPROVED')
            ->with([
                'category',
                'location',
            ])
            ->get();

        $matches = [];

        foreach ($candidates as $candidate) {
            $score = $this->calculateScore(
                $report,
                $candidate
            );

            // Hanya kandidat dengan score minimal 60
            // yang dianggap sebagai kemungkinan cocok.
            if ($score >= 60) {
                $matches[] = [
                    'report' => $candidate,
                    'score' => $score,
                ];
            }
        }

        // Urutkan dari score tertinggi ke terendah.
        usort($matches, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        return $matches;
    }

    /**
     * Menyimpan hasil matching ke database.
     */
   public function saveMatches(Report $report): void
{
    $matches = $this->findMatches($report);

    foreach ($matches as $match) {
        $candidate = $match['report'];
        $score = $match['score'];

        $lostReportId = $report->type === 'LOST'
            ? $report->id
            : $candidate->id;

        $foundReportId = $report->type === 'FOUND'
            ? $report->id
            : $candidate->id;

        $reportMatch = ReportMatch::firstOrCreate(
            [
                'lost_report_id' => $lostReportId,
                'found_report_id' => $foundReportId,
            ],
            [
                'score' => $score,
                'status' => 'SUGGESTED',
            ]
        );

        if ($reportMatch->wasRecentlyCreated) {
            $report->user->notify(
                new ReportMatchNotification(
                    $report,
                    $candidate,
                    $score
                )
            );

            $candidate->user->notify(
                new ReportMatchNotification(
                    $candidate,
                    $report,
                    $score
                )
            );
        }
    }
}
    /**
     * Menghitung skor kecocokan dua laporan.
     */
    public function calculateScore(
        Report $report,
        Report $candidate
    ): int {
        $score = 0;

        // 1. Kategori
        if ($report->category_id === $candidate->category_id) {
            $score += 30;
        }

        // 2. Lokasi
        if ($report->location_id === $candidate->location_id) {
            $score += 20;
        }

        // 3. Merek
        $reportBrand = strtolower(
            trim($report->brand ?? '')
        );

        $candidateBrand = strtolower(
            trim($candidate->brand ?? '')
        );

        $invalidBrands = [
            '',
            '-',
            'n/a',
            'na',
            'tidak ada',
            'tidak diketahui',
        ];

        if (
            !in_array($reportBrand, $invalidBrands) &&
            !in_array($candidateBrand, $invalidBrands) &&
            $reportBrand === $candidateBrand
        ) {
            $score += 15;
        }

        // 4. Warna
        if (
            $report->color &&
            $candidate->color &&
            strtolower(trim($report->color)) ===
            strtolower(trim($candidate->color))
        ) {
            $score += 10;
        }

        // 5. Tanggal berdekatan
        $daysDifference = abs(
            $report->event_date->diffInDays(
                $candidate->event_date
            )
        );

        if ($daysDifference <= 1) {
            $score += 15;
        } elseif ($daysDifference <= 3) {
            $score += 10;
        } elseif ($daysDifference <= 7) {
            $score += 5;
        }

        // 6. Kemiripan teks
        $score += $this->calculateTextSimilarity(
            $report,
            $candidate
        );

        return $score;
    }

    /**
     * Menghitung kemiripan antara judul dan deskripsi.
     */
    private function calculateTextSimilarity(
        Report $report,
        Report $candidate
    ): int {
        $textReport = strtolower(
            $report->title . ' ' . $report->description
        );

        $textCandidate = strtolower(
            $candidate->title . ' ' . $candidate->description
        );

        similar_text(
            $textReport,
            $textCandidate,
            $percent
        );

        // Jika kemiripan teks minimal 60%,
        // berikan tambahan 10 poin.
        if ($percent >= 60) {
            return 10;
        }

        return 0;
    }
}