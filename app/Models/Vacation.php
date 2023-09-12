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
    protected $casts=[
        'from',
        'to',
      ];
      public function user(){
        return $this->belongsTo(User::class);
      }


}
