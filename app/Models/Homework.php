<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Homework extends Model
{
    use HasFactory;

 /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "homeworks";

    protected $fillable = [
      'description',
      'from_date',
      'to_date',
      'is_lifetime',
      'user_id',

    ];
    protected $casts=[
      'from_date' => 'datetime',
      'to_date' => 'datetime',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
      return $this->belongsTo(User::class);
    }

}
