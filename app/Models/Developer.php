<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Developer extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'name',
        'company',
        'url',
    ];

    /**
     * @return HasMany
     */
    public function repositories(): HasMany
    {
        return $this->hasMany(Repository::class);
    }
}
