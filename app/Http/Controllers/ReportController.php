<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Location;
use App\Models\Report;
use App\Models\ReportImage;
use App\Rules\NoEmoji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type');
        $categoryId = $request->input('category_id');
        $locationId = $request->input('location_id');

        $categories = Category::all();
        $locations = Location::all();

        $reports = Report::with([
            'user',
            'category',
            'location',
            'images',
        ])
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhere('brand', 'like', '%' . $search . '%')
                        ->orWhere('color', 'like', '%' . $search . '%');
                });
            })
            ->when($type, function ($query, $type) {
                $query->where('type', $type);
            })
            ->when($categoryId, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($locationId, function ($query, $locationId) {
                $query->where('location_id', $locationId);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('reports.index', compact(
            'reports',
            'search',
            'type',
            'categoryId',
            'locationId',
            'categories',
            'locations'
        ));
    }

    public function create()
    {
        $categories = Category::all();
        $locations = Location::all();

        return view('reports.create', compact(
            'categories',
            'locations'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => [
                'required',
                'in:LOST,FOUND',
            ],
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
                new NoEmoji,
            ],
            'description' => [
                'required',
                'string',
            ],
            'brand' => [
                'nullable',
                'string',
                'max:100',
                new NoEmoji,
            ],
            'color' => [
                'nullable',
                'string',
                'max:50',
                new NoEmoji,
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

        $validated['user_id'] = auth()->id();

        $report = Report::create($validated);

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

    public function show(Report $report)
    {
        $report->load([
            'user',
            'category',
            'location',
            'images',
        ]);

        return view('reports.show', compact(
            'report'
        ));
    }

    public function matches(Report $report)
    {
        $report->load([
            'user',
            'category',
            'location',
            'images',
        ]);

        $matches = $report->type === 'LOST'
            ? $report->lostMatches()
                ->with([
                    'foundReport.category',
                    'foundReport.location',
                    'foundReport.images',
                ])
                ->where('status', 'SUGGESTED')
                ->orderByDesc('score')
                ->get()
            : $report->foundMatches()
                ->with([
                    'lostReport.category',
                    'lostReport.location',
                    'lostReport.images',
                ])
                ->where('status', 'SUGGESTED')
                ->orderByDesc('score')
                ->get();

        return view('reports.matches', compact(
            'report',
            'matches'
        ));
    }

    public function edit(Report $report)
    {
        Gate::authorize('update', $report);

        $categories = Category::all();
        $locations = Location::all();

        $report->load('images');

        return view('reports.edit', compact(
            'report',
            'categories',
            'locations'
        ));
    }

    public function update(Request $request, Report $report)
    {
        Gate::authorize('update', $report);

        $validated = $request->validate([
            'type' => [
                'required',
                'in:LOST,FOUND',
            ],
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
                new NoEmoji,
            ],
            'description' => [
                'required',
                'string',
            ],
            'brand' => [
                'nullable',
                'string',
                'max:100',
                new NoEmoji,
            ],
            'color' => [
                'nullable',
                'string',
                'max:50',
                new NoEmoji,
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

        $report->update($validated);

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

    public function destroy(Report $report)
    {
        Gate::authorize('delete', $report);

        foreach ($report->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $report->delete();

        return redirect()
            ->route('reports.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}