<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'base_salary',
        'bonus',
        'deduction',
        'advance_deduction',
        'fine_deduction',
        'overtime_amount',
        'final_salary',
        'payment_status',
        'paid_at',
        'note',
    ];

    protected $casts = [
        'month' => 'integer',
        'year' => 'integer',
        'base_salary' => 'decimal:2',
        'bonus' => 'decimal:2',
        'deduction' => 'decimal:2',
        'advance_deduction' => 'decimal:2',
        'fine_deduction' => 'decimal:2',
        'overtime_amount' => 'decimal:2',
        'final_salary' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function getMonthNameAttribute(): string
    {
        $months = [
            1 => 'Yanvar', 2 => 'Fevral', 3 => 'Mart', 4 => 'Aprel',
            5 => 'May', 6 => 'İyun', 7 => 'İyul', 8 => 'Avqust',
            9 => 'Sentyabr', 10 => 'Oktyabr', 11 => 'Noyabr', 12 => 'Dekabr',
        ];
        return $months[$this->month] ?? $this->month;
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return match($this->payment_status) {
            'pending' => 'Gözləmədə',
            'paid' => 'Ödənilib',
            default => $this->payment_status,
        };
    }

    public function getPaymentStatusColorAttribute(): string
    {
        return match($this->payment_status) {
            'pending' => 'warning',
            'paid' => 'success',
            default => 'secondary',
        };
    }

    public function scopeForMonth($query, $year, $month)
    {
        return $query->where('year', $year)->where('month', $month);
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function calculateFinalSalary(): void
    {
        $this->final_salary = $this->base_salary
            + $this->bonus
            + $this->overtime_amount
            - $this->deduction
            - $this->advance_deduction
            - $this->fine_deduction;
    }
}
