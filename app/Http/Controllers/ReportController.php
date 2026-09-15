<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Location;
use App\Models\Report;
use App\Models\ReportImage;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Report::with([
            'user',
            'category',
            'location',
            'images',
        ])->latest()->get();

        return view('reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $locations = Location::all();

        return view('reports.create', compact('categories', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:LOST,FOUND'],

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'location_id' => [
                'required',
                'exists:locations,id',
            ],

            'title' => [
                'required',
                'string',
                'max:150',
            ],

            'description' => [
                'required',
                'string',
            ],

            'brand' => [
                'nullable',
                'string',
                'max:100',
            ],

            'color' => [
                'nullable',
                'string',
                'max:50',
            ],

            'event_date' => [
                'required',
                'date',
            ],

            'contact_info' => [
                'nullable',
                'string',
                'max:255',
            ],

            'images' => [
                'nullable',
                'array',
            ],

            'images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        // Tambahkan user yang sedang login
        $validated['user_id'] = auth()->id();

        // Simpan data laporan
        $report = Report::create($validated);

        // Simpan foto jika ada
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {

                $path = $image->store('reports', 'public');

                ReportImage::create([
                    'report_id' => $report->id,
                    'path' => $path,
                    'original_name' => $image->getClientOriginalName(),
                ]);
            }
        }

        return redirect()
            ->route('reports.index')
            ->with('success', 'Laporan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        $report->load([
            'user',
            'category',
            'location',
            'images',
        ]);

        return view('reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        $categories = Category::all();
    $locations = Location::all();

    $report->load('images');

    return view('reports.edit', compact(
        'report',
        'categories',
        'locations'
    ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
         $validated = $request->validate([
        'type' => ['required', 'in:LOST,FOUND'],

        'category_id' => [
            'required',
            'exists:categories,id',
        ],

        'location_id' => [
            'required',
            'exists:locations,id',
        ],

        'title' => [
            'required',
            'string',
            'max:150',
        ],

        'description' => [
            'required',
            'string',
        ],

        'brand' => [
            'nullable',
            'string',
            'max:100',
        ],

        'color' => [
            'nullable',
            'string',
            'max:50',
        ],

        'event_date' => [
            'required',
            'date',
        ],

        'contact_info' => [
            'nullable',
            'string',
            'max:255',
        ],

        'images' => [
            'nullable',
            'array',
        ],

        'images.*' => [
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:5120',
        ],
    ]);

    // Update data laporan
    $report->update($validated);

    // Tambahkan foto baru jika ada
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {

            $path = $image->store('reports', 'public');

            ReportImage::create([
                'report_id' => $report->id,
                'path' => $path,
                'original_name' => $image->getClientOriginalName(),
            ]);
        }
    }

    return redirect()
        ->route('reports.show', $report)
        ->with('success', 'Laporan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        // Hapus semua file foto dari storage
    foreach ($report->images as $image) {
        \Illuminate\Support\Facades\Storage::disk('public')
            ->delete($image->path);
    }

    // Hapus laporan
    // report_images ikut terhapus karena cascadeOnDelete()
    $report->delete();

    return redirect()
        ->route('reports.index')
        ->with('success', 'Laporan berhasil dihapus.');
    }
}