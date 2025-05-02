<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contract extends Model
{
    public function employee(): BelongsTo
    {
        return $this->belongsTo(related: Employee::class);
    }

    public function designation(): BelongsTo
    {
        return $this->belongsTo(related: Designation::class);
    }

    public function scopeInCompany($query): mixed
    {
        return $query->whereHas('designation', function ($q): void{
            $q->inCompany();
        });
    }

    public function getDurationAttribute(): string
    {
        return Carbon::parse($this->start_date)->diffForHumans($this->end_date);
    }

    public function scopeSearchByName($query, $name): mixed
    {
        return $query->whereHas('employee', function ($q) use ($name): void{
            $q->where('name', 'like', "%$name%");
        });
    }

    public function getTotalEarnings($monthYear): mixed
    {
        return $this->rate_type == 'monthly' ? $this->rate : $this->rate * Carbon::parse(time: $monthYear)->daysInMonth;
    }
}
