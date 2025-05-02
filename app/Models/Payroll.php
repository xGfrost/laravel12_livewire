<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Payroll extends Model
{
    public function company(): BelongsTo
    {
        return $this->belongsTo(related: Company::class);
    }
    public function salaries(): BelongsToMany
    {
        return $this->belongsToMany(related: Salary::class);
    }
    public function payments(): BelongsToMany
    {
        return $this->belongsToMany(related: Payment::class);
    }
    public function scopeInCompany($query): mixed
    {
        return $query->whereHas('company_id', $this->company_id);
    }
    public function getMonthYearAttribute(): string
    {
        return $this->year . '-' . $this->month;
    }
    public function getMonthStringAttribute($value): string
    {
        return Carbon::parse(time: $this->month_year)->format(format: 'F Y');
    }
}
