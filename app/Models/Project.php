<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'address',
        'manager_name',
        'start_date',
        'end_date',
        'status',
        'note',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'employee_project')
            ->withPivot('assigned_at', 'status')
            ->withTimestamps();
    }

    public function activeEmployees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'employee_project')
            ->wherePivot('status', 'active')
            ->withPivot('assigned_at', 'status')
            ->withTimestamps();
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function fines(): HasMany
    {
        return $this->hasMany(Fine::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function getEmployeeCountAttribute(): int
    {
        return $this->activeEmployees()->count();
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'active' => 'Aktiv',
            'completed' => 'Tamamlanmış',
            'on_hold' => 'Dayandırılmış',
            'cancelled' => 'Ləğv edilmiş',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'active' => 'success',
            'completed' => 'info',
            'on_hold' => 'warning',
            'cancelled' => 'secondary',
            default => 'secondary',
        };
    }
}
