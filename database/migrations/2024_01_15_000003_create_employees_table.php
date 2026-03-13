<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('father_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('identity_number')->nullable()->unique();
            $table->date('birth_date')->nullable();
            $table->text('address')->nullable();
            $table->string('position')->nullable();
            $table->string('department')->nullable();
            $table->enum('salary_type', ['monthly', 'daily', 'hourly'])->default('monthly');
            $table->decimal('salary_amount', 12, 2)->default(0);
            $table->decimal('daily_salary', 12, 2)->default(0);
            $table->decimal('hourly_salary', 12, 2)->default(0);
            $table->date('hire_date');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('photo')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
