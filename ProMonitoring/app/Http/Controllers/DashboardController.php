<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik proyek
        $totalProjects = Project::count();
        $completedProjects = Project::byStatus('selesai')->count();
        $activeProjects = Project::byStatus('aktif')->count();
        $progressProjects = Project::byStatus('progress')->count();

        $statistics = [
            'total' => $totalProjects,
            'completed' => $completedProjects,
            'active' => $activeProjects,
            'progress' => $progressProjects
        ];

        return view('dashboard', compact('statistics'));
    }
}