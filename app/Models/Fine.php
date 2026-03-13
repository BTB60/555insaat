<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fine extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'project_id',
        'amount',
        'reason',
        'fine_date',
        'status',
        'note',
        'created_by',
    ];

    protected $casts = [
        'fine_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'active' => 'Aktiv',
            'deducted' => 'Çıxılıb',
            'cancelled' => 'Ləğv edilib',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'active' => 'danger',
            'deducted' => 'success',
            'cancelled' => 'secondary',
            default => 'secondary',
        };
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeDeducted($query)
    {
        return $query->where('status', 'deducted');
    }

    public function scopeForEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }
}
