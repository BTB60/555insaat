<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'project_id',
        'date',
        'status',
        'check_in',
        'check_out',
        'note',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'present' => 'Gəlib',
            'late' => 'Gecikib',
            'absent' => 'Gəlməyib',
            'excused' => 'Üzrlü',
            'vacation' => 'Məzuniyyət',
            'sick' => 'Xəstə',
            'half_day' => 'Yarım gün',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'present' => 'success',
            'late' => 'warning',
            'absent' => 'danger',
            'excused' => 'info',
            'vacation' => 'primary',
            'sick' => 'secondary',
            'half_day' => 'info',
            default => 'secondary',
        };
    }

    public function scopeForDate($query, $date)
    {
        return $query->where('date', $date);
    }

    public function scopeForEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    public function scopeForProject($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    public function scopePresent($query)
    {
        return $query->whereIn('status', ['present', 'late', 'half_day']);
    }

    public function scopeAbsent($query)
    {
        return $query->where('status', 'absent');
    }
}
