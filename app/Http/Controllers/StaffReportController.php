<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Services\ReportMatchingService;
use App\Notifications\ReportStatusNotification;

class StaffReportController extends Controller
{
    public function index()
    {
        $reports = Report::with([
            'user',
            'category',
            'location',
            'images',
        ])
            ->where('status', 'PENDING')
            ->latest()
            ->get();

        return view('staff.reports.index', compact('reports'));
    }

    public function approve(
        Report $report,
        ReportMatchingService $matchingService
    ) {
        if ($report->status !== 'PENDING') {
            abort(404);
        }

        $report->update([
            'status' => 'APPROVED',
        ]);

        $report->user->notify(
            new ReportStatusNotification($report, 'APPROVED')
        );

        $matchingService->saveMatches($report);

        return redirect()
            ->route('staff.reports.index')
            ->with('success', 'Laporan berhasil disetujui.');
    }

    public function reject(Report $report)
    {
        if ($report->status !== 'PENDING') {
            abort(404);
        }

        $report->update([
            'status' => 'REJECTED',
        ]);

        $report->user->notify(
            new ReportStatusNotification($report, 'REJECTED')
        );

        return redirect()
            ->route('staff.reports.index')
            ->with('success', 'Laporan berhasil ditolak.');
    }
}