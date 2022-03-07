<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Repository extends Model
{
    use HasFactory;

    protected $fillable = [
        'github_repo_id',
        'developer_id',
        'name',
        'language',
    ];

    /**
     * @return BelongsTo
     */
    public function developer() : BelongsTo
    {
        return $this->belongsTo(Developer::class);
    }
}
