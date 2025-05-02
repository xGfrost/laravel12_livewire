<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'designation_id',
    ];

    public function designation(): BelongsTo
    {
        return $this->belongsTo(related: Designation::class);
    }

    public function department(): mixed
    {
        return $this->designation->department;
    }

    public function scopeInCompany($query): mixed
    {
        return $query->whereHas('designation', function ($q): void{
            $q->inCompany();
        });
    }

    public function scopeSearchByName($query, $name){
        return $query->where('name', 'like', '%' . $name . '%');
    }


    public function selaries(): HasMany
    {
        return $this->hasMany(related: Salary::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(related: Payment::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(related: Contract::class);
    }

    public function getActiveContract($startDate = null, $endDate = null): Contract|null
    {
        $start_date = $start_date ?? now();
        $end_date = $end_date ?? now();
        return $this->contracts()->where(column: 'start_date', operator: '<=', value: $start_date)
            ->where(column: 'end_date', operator: '>=', value: $end_date)
            ->first();
        }
}
