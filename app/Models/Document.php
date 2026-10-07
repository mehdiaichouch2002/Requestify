<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'status',
        'attached_files',
        'type',
        'user_id',
    ];



    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        // Keep showing requests from people who were since removed (users are soft-deleted)
        return $this->belongsTo(User::class)->withTrashed();
    }
}
