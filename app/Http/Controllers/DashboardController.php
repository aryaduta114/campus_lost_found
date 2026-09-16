<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Report;

class DashboardController extends Controller
{
    public function index()
    {
        $totalReports = Report::count();

        $lostReports = Report::where('type', 'LOST')->count();

        $foundReports = Report::where('type', 'FOUND')->count();

        $pendingReports = Report::where('status', 'PENDING')->count();

        $approvedReports = Report::where('status', 'APPROVED')->count();

        $claimedReports = Report::where('status', 'CLAIMED')->count();

        $returnedReports = Report::where('status', 'RETURNED')->count();

        $pendingClaims = Claim::where('status', 'PENDING')->count();

        $latestReports = Report::with([
            'category',
            'location',
        ])
            ->latest()
            ->take(5)
            ->get();

        $myReports = Report::with([
            'category',
            'location',
        ])
            ->where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalReports',
            'lostReports',
            'foundReports',
            'pendingReports',
            'approvedReports',
            'claimedReports',
            'returnedReports',
            'latestReports',
            'pendingClaims',
            'myReports',
        ));
    }
}