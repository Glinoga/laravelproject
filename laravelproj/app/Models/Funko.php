<?php

// app/Models/Funko.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Funko extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'name',
        'description',
        'sold_out',
        'image', // Add image here
    ];

    // Accessor to get the full URL for the image
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}

