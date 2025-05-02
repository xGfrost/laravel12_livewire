<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Designation extends Model
{
    protected $fillable = [
        'name',
        'department_id',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(related:Department::class);
    }

    public function employess(): HasMany
    {
        return $this->hasMany(related:Employee::class);
    }

    public function scopeInCompany($query): mixed
    {
        return $query->whereHas('department', function ($q):void {
            $q->inCompany();
        });
    }
}
