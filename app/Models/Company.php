<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'name',
        'email',
        'logo',
        'website',
    ];

    public function users():BelongsToMany
    {
        return $this->belongsToMany(related: User::class, table: 'company_user');
    }

    public function departments():HasMany
    {
        return $this->HasMany(related: Department::class);
    }

    public function designations(): HasMany
    {
        return $this->throuhDepartments()->hasDesignations();
    }

    public function getLogoUrlAttribute(): string
    {
        return $this->logo ? asset(path: 'storage/' .$this->logo) : asset(path: 'images/default-logo.png');
    }

    
}


