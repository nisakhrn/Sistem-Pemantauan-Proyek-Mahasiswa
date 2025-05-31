<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Project::query();

        // Search functionality
        if ($request->has('q') && $request->q) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->byStatus($request->status);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date) {
            $query->where('start_date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->where('end_date', '<=', $request->end_date);
        }

        $projects = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get status counts for dashboard/statistics
        $statusCounts = [
            'total' => Project::count(),
            'progress' => Project::byStatus('progress')->count(),
            'aktif' => Project::byStatus('aktif')->count(),
            'selesai' => Project::byStatus('selesai')->count(),
            'overdue' => Project::overdue()->count(),
        ];

        if ($request->ajax()) {
            return response()->json([
                'html' => view('projects.table', compact('projects'))->render(),
                'pagination' => $projects->links()->render(),
                'statusCounts' => $statusCounts
            ]);
        }

        return view('projects.index', compact('projects', 'statusCounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // DEBUG: Log semua data yang masuk
        Log::info('=== PROJECT STORE METHOD CALLED ===');
        Log::info('Request method: ' . $request->method());
        Log::info('Request URL: ' . $request->fullUrl());
        Log::info('Request headers: ', $request->headers->all());
        Log::info('Request all data: ', $request->all());
        Log::info('Request input: ', $request->input());
        
        // Cek apakah ini request POST yang benar
        if (!$request->isMethod('POST')) {
            Log::error('Method tidak POST: ' . $request->method());
            return redirect()->back()->with('error', 'Method tidak valid');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:progress,aktif,selesai'
        ], [
            'title.required' => 'Judul proyek harus diisi',
            'title.max' => 'Judul proyek maksimal 255 karakter',
            'description.required' => 'Deskripsi harus diisi',
            'start_date.required' => 'Tanggal mulai harus diisi',
            'start_date.date' => 'Format tanggal mulai tidak valid',
            'end_date.required' => 'Tanggal selesai harus diisi',
            'end_date.date' => 'Format tanggal selesai tidak valid',
            'end_date.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
            'status.required' => 'Status harus dipilih',
            'status.in' => 'Status tidak valid'
        ]);

        Log::info('Validation rules applied');

        if ($validator->fails()) {
            Log::error('Validation failed: ', $validator->errors()->toArray());
            
            if ($request->ajax()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Log::info('Validation passed, attempting to create project');

        try {
            // Debug: Log data yang akan disimpan
            $dataToSave = $request->only(['title', 'description', 'start_date', 'end_date', 'status']);
            
            // Tambahkan user_id (wajib karena ada di migration)
            $dataToSave['user_id'] = auth()->id() ?? 1; // Default ke user ID 1 jika tidak login
            
            // DEBUG: Log data sebelum dan sesudah menambah user_id
            Log::info('Data before adding user_id: ', $request->only(['title', 'description', 'start_date', 'end_date', 'status']));
            Log::info('Auth user ID: ', [auth()->id()]);
            Log::info('Final data to save: ', $dataToSave);
            Log::info('Model fillable: ', (new Project())->getFillable());
            
            $project = Project::create($dataToSave);
            
            Log::info('Project created successfully: ', $project->toArray());
            Log::info('Project ID: ' . $project->id);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Proyek berhasil ditambahkan',
                    'project' => $project
                ]);
            }

            Log::info('Redirecting to projects.index with success message');
            return redirect()->route('projects.index')->with('success', 'Proyek berhasil ditambahkan');
            
        } catch (\Exception $e) {
            Log::error('Exception occurred while creating project: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan proyek: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan proyek: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        if (request()->ajax()) {
            return response()->json($project);
        }
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        // DEBUG: Log update request
        Log::info('=== PROJECT UPDATE METHOD CALLED ===');
        Log::info('Project ID: ' . $project->id);
        Log::info('Request method: ' . $request->method());
        Log::info('Request data: ', $request->all());

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:progress,aktif,selesai'
        ], [
            'title.required' => 'Judul proyek harus diisi',
            'title.max' => 'Judul proyek maksimal 255 karakter',
            'description.required' => 'Deskripsi harus diisi',
            'start_date.required' => 'Tanggal mulai harus diisi',
            'start_date.date' => 'Format tanggal mulai tidak valid',
            'end_date.required' => 'Tanggal selesai harus diisi',
            'end_date.date' => 'Format tanggal selesai tidak valid',
            'end_date.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
            'status.required' => 'Status harus dipilih',
            'status.in' => 'Status tidak valid'
        ]);

        if ($validator->fails()) {
            Log::error('Update validation failed: ', $validator->errors()->toArray());
            
            if ($request->ajax()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $dataToUpdate = $request->only(['title', 'description', 'start_date', 'end_date', 'status']);
            // PERBAIKAN: Tambahkan user_id jika diperlukan (biasanya untuk update tidak perlu mengubah user_id)
            // $dataToUpdate['user_id'] = auth()->id() ?? $project->user_id;
            Log::info('Data to update: ', $dataToUpdate);
            
            $project->update($dataToUpdate);
            
            Log::info('Project updated successfully');
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Proyek berhasil diperbarui',
                    'project' => $project
                ]);
            }

            return redirect()->route('projects.index')->with('success', 'Proyek berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Exception occurred while updating project: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memperbarui proyek'
                ], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui proyek')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        try {
            $project->delete();
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Proyek berhasil dihapus'
                ]);
            }

            return redirect()->route('projects.index')->with('success', 'Proyek berhasil dihapus');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menghapus proyek'
                ], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus proyek');
        }
    }

    /**
     * Update project status.
     */
    public function updateStatus(Request $request, Project $project)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:progress,aktif,selesai'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        try {
            $project->update(['status' => $request->status]);
            return redirect()->back()->with('success', 'Status proyek berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui status');
        }
    }
}