<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\ReportReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnController extends Controller
{
    public function create(Claim $claim)
    {
        if ($claim->status !== 'APPROVED') {
            abort(404);
        }

        if ($claim->report->status !== 'CLAIMED') {
            abort(404);
        }

        if ($claim->return) {
            abort(404);
        }

        return view('returns.create', compact('claim'));
    }

    public function store(Request $request, Claim $claim)
    {
        if ($claim->status !== 'APPROVED') {
            abort(404);
        }

        if ($claim->report->status !== 'CLAIMED') {
            abort(404);
        }

        if ($claim->return) {
            abort(404);
        }

        $validated = $request->validate([
            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        DB::transaction(function () use ($claim, $validated) {
            ReportReturn::create([
                'report_id' => $claim->report_id,
                'claim_id' => $claim->id,
                'returned_by' => auth()->id(),
                'received_by' => $claim->user_id,
                'returned_at' => now(),
                'notes' => $validated['notes'] ?? null,
            ]);

            $claim->report->update([
                'status' => 'RETURNED',
            ]);
        });

        return redirect()
            ->route('staff.claims.index')
            ->with(
                'success',
                'Pengembalian barang berhasil dicatat.'
            );
    }
}