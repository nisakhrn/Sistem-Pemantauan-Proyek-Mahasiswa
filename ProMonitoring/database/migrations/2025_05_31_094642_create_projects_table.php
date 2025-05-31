<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('projects', function (Blueprint $table) {
        $table->id();
        $table->string('title', 255);
        $table->text('description');
        $table->date('start_date');
        $table->date('end_date');
        $table->enum('status', ['Aktif', 'Progress', 'Selesai', 'Tertunda'])->default('Aktif');
        $table->string('student_name', 100)->nullable();
        $table->string('student_nim', 20)->nullable();
        $table->decimal('progress_percentage', 5, 2)->default(0.00);

        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Menambahkan foreign key yang mengacu ke tabel users
        $table->timestamps();

        $table->index('status');
        $table->index('start_date');
        $table->index('end_date');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
