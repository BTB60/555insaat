<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'id_number',
        'birth_date',
        'address',
        'photo',
        'user_type',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
        ];
    }

    public function worker(): HasOne
    {
        return $this->hasOne(Worker::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'recorded_by');
    }

    public function salaries(): HasMany
    {
        return $this->hasMany(Salary::class, 'calculated_by');
    }

    public function advancesApproved(): HasMany
    {
        return $this->hasMany(Advance::class, 'approved_by');
    }

    public function penaltiesIssued(): HasMany
    {
        return $this->hasMany(Penalty::class, 'issued_by');
    }

    public function managedSites(): HasMany
    {
        return $this->hasMany(Site::class, 'manager_id');
    }

    public function createdTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isAccountant(): bool
    {
        return $this->hasRole('accountant');
    }

    public function isWorker(): bool
    {
        return $this->hasRole('worker');
    }

    public function getFullNameAttribute(): string
    {
        return $this->name;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeWorkers($query)
    {
        return $query->where('user_type', 'worker');
    }
}
