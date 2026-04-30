<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaySlip extends Model
{
    protected $fillable = [
        'user_id',
        'pay_date',
        'base_salary',
        'total_hours_worked',
        'total_overtime_hours',
        'overtime_pay',
        'bonus_amount',
        'total_deductions',
        'net_pay',
        'file_path'
    ];

    protected $casts = [
        'pay_date' => 'date',
        'base_salary' => 'decimal:2',
        'overtime_pay' => 'decimal:2',
        'bonus_amount' => 'decimal:2',
        'total_deductions' => 'decimal:2',
        'net_pay' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
