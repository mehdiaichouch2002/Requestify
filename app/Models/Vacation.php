<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vacation extends Model
{
    use HasFactory;

 /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "vacations";
    protected $fillable = [
        'description',
        'title',
        'from',
        'to',
        'paid',
        'attached_file',
        'user_id',

    ];
    protected $casts = [
        'from' => 'date',
        'to' => 'date',
        'paid' => 'boolean',
    ];

    /**
     * Calendar days covered by the leave, counting both the first and the last day.
     */
    public function days(): int
    {
        return $this->from->diffInDays($this->to ?? $this->from) + 1;
    }
      public function user(){
        // Keep showing requests from people who were since removed (users are soft-deleted)
        return $this->belongsTo(User::class)->withTrashed();
      }


}
