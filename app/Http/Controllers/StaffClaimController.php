<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Notifications\ClaimStatusNotification;

class StaffClaimController extends Controller
{
    public function index()
    {
        $claims = Claim::with([
            'user',
            'report.category',
            'report.location',
            'report.images',
            'return',
        ])
            ->whereIn('status', ['PENDING', 'APPROVED'])
            ->latest()
            ->get();

        return view('staff.claims.index', compact('claims'));
    }

    public function approve(Claim $claim)
    {
        if ($claim->status !== 'PENDING') {
            abort(404);
        }

        if ($claim->report->status !== 'APPROVED') {
            abort(404);
        }

        $claim->update([
            'status' => 'APPROVED',
        ]);

        $claim->report->update([
            'status' => 'CLAIMED',
        ]);

        $claim->user->notify(
            new ClaimStatusNotification($claim)
        );

        return redirect()
            ->route('staff.claims.index')
            ->with(
                'success',
                'Klaim berhasil disetujui dan laporan ditandai sebagai CLAIMED.'
            );
    }

    public function reject(Claim $claim)
    {
        if ($claim->status !== 'PENDING') {
            abort(404);
        }

        if ($claim->report->status !== 'APPROVED') {
            abort(404);
        }

        $claim->update([
            'status' => 'REJECTED',
        ]);

        $claim->user->notify(
            new ClaimStatusNotification($claim)
        );

        return redirect()
            ->route('staff.claims.index')
            ->with('success', 'Klaim berhasil ditolak.');
    }
}