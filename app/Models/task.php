<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class task extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','title','expiration_date','description', 'complete'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
