<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'first_name',
        'last_name',
        'fiscal_code',
        'base_salary',
        'hiring_date',
        'department_id',
        'contract_id',
        'manager_id',
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
        ];
    }


    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function timesheets(): HasMany
    {
        return $this->hasMany(Timesheet::class);
    }


    public function absences(): HasMany
    {
        return $this->hasMany(Absence::class);
    }

    public function paySlips(): HasMany
    {
        return $this->hasMany(PaySlip::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isManager(): bool
    {
        return $this->role === 'manager';
    }


    public function managedEmployees(): HasMany
    {
        return $this->hasMany(User::class, 'manager_id');
    }

    public function employees(): HasMany
    {

        return $this->hasMany(User::class, 'manager_id');
    }
}
