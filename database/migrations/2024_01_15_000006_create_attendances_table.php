<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->date('date');
            $table->enum('status', [
                'present',      // gelib
                'late',         // gecikib
                'absent',       // gelmeyib
                'excused',      // uzrlu
                'vacation',     // mezuniyyet
                'sick',         // xeste
                'half_day'      // yarim gun
            ])->default('present');
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->decimal('work_hours', 4, 2)->nullable();
            $table->decimal('overtime_hours', 4, 2)->default(0);
            $table->foreignId('recorded_by')->constrained('users');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['employee_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
