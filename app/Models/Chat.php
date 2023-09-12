<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','other_user_id','message','type','group_id','is_read'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
