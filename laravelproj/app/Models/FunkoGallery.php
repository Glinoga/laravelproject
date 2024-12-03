<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FunkoGallery extends Model
{
    protected $table = 'funko_galleries'; // Explicitly defining the table name
    protected $fillable = ['user_id', 'title', 'description', 'image_path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

