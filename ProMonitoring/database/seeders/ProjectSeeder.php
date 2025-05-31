<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use Carbon\Carbon;
use App\Models\User;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ambil semua pengguna yang ada
        $users = User::all();

        // Pastikan ada pengguna yang tersedia
        if ($users->isEmpty()) {
            $this->command->info('Tidak ada pengguna di database, menambahkan data pengguna terlebih dahulu!');
            return;
        }

        // Menyiapkan proyek kosong untuk diisi oleh pengguna
        foreach ($users as $user) {
            // Proyek dengan nilai default kosong
            Project::create([
                'title' => 'Proyek Baru',
                'description' => 'Deskripsi proyek belum diisi.',
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(3),
                'status' => 'Aktif',
                'user_id' => $user->id,  // Menghubungkan proyek dengan pengguna
                'progress_percentage' => 0.00,
            ]);
        }

        // Menambahkan proyek acak tambahan untuk testing
        $this->createRandomProjects(10);
    }

    /**
     * Create random projects for testing
     */
    private function createRandomProjects($count)
    {
        $titles = [
            'Sistem Inventori Barang',
            'Aplikasi Delivery Food',
            'Platform Learning Management',
            'Website Company Profile',
            'Aplikasi Chat Messenger',
        ];

        $statuses = ['Aktif', 'Progress', 'Selesai', 'Tertunda'];

        for ($i = 0; $i < $count; $i++) {
            // Pilih pengguna secara acak untuk proyek ini
            $user = User::inRandomOrder()->first();
            $status = $statuses[array_rand($statuses)];

            // Tentukan progress berdasarkan status
            $progress = match($status) {
                'Selesai' => 100.00,
                'Progress' => (float) rand(20, 90),
                'Aktif' => (float) rand(10, 50),
                'Tertunda' => (float) rand(5, 30),
            };

            // Tentukan tanggal mulai dan akhir secara acak
            $startDate = Carbon::now()->subDays(rand(30, 365));
            $endDate = $startDate->copy()->addDays(rand(60, 180));

            // Sisipkan proyek acak ke dalam database
            Project::create([
                'title' => $titles[array_rand($titles)] . ' ' . ($i + 1),
                'description' => 'Deskripsi proyek belum diisi.',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => $status,
                'user_id' => $user->id,  // Menghubungkan proyek dengan pengguna
                'progress_percentage' => $progress,
            ]);
        }
    }
}
