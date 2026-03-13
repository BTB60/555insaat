<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'father_name',
        'phone',
        'identity_number',
        'birth_date',
        'address',
        'position',
        'department',
        'salary_type',
        'salary_amount',
        'daily_salary',
        'hourly_salary',
        'hire_date',
        'status',
        'photo',
        'note',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'hire_date' => 'date',
        'salary_amount' => 'decimal:2',
        'daily_salary' => 'decimal:2',
        'hourly_salary' => 'decimal:2',
    ];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'employee_project')
            ->withPivot('assigned_at', 'status')
            ->withTimestamps();
    }

    public function currentProject(): ?Project
    {
        return $this->projects()
            ->wherePivot('status', 'active')
            ->first();
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function salaries(): HasMany
    {
        return $this->hasMany(Salary::class);
    }

    public function advances(): HasMany
    {
        return $this->hasMany(Advance::class);
    }

    public function fines(): HasMany
    {
        return $this->hasMany(Fine::class);
    }

    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_employee')
            ->withTimestamps();
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function getFullNameAttribute(): string
    {
        return $this->attributes['full_name'];
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }
}
