<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Report;
use Illuminate\Http\Request;

class ClaimController extends Controller
{
    public function create(Report $report)
    {
        if ($report->type !== 'FOUND') {
            abort(404);
        }

        if ($report->status !== 'APPROVED') {
            abort(404);
        }

        return view('claims.create', compact('report'));
    }

    public function store(Request $request, Report $report)
    {
        if ($report->type !== 'FOUND') {
            abort(404);
        }

        if ($report->status !== 'APPROVED') {
            abort(404);
        }

        $validated = $request->validate([
            'reason' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);

        Claim::create([
            'report_id' => $report->id,
            'user_id' => auth()->id(),
            'reason' => $validated['reason'],
            'status' => 'PENDING',
        ]);

        return redirect()
            ->route('reports.show', $report)
            ->with('success', 'Klaim berhasil diajukan dan menunggu verifikasi staff.');
    }
}