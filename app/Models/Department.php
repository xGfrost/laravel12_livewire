<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = [
        'name',
        'company_id',

    ];
    public function company(): BelongsTo
    {
        return $this->belongsTo(related: Company::class);
    }

    public function designations():HasMany
    {
        return $this->hasMany(related: Designation::class);
    }

    public function employess(): mixed
    {
        return $this->throughDesignations()->hasEmployess();
    }

    public function scopeInCompany($query): mixed
    {
        return $query->where('company_id', session(key: 'company_id'));
    }
}
