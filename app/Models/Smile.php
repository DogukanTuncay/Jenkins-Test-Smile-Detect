<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Smile extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'image_path', 'smile_detected'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
