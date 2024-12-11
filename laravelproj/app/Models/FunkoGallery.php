<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class FunkoGallery extends Model
{
    use HasFactory, SoftDeletes; // This ensures soft delete functionality
    protected $table = 'funko_galleries'; // Explicitly defining the table name
    protected $fillable = ['user_id', 'title', 'description', 'image_path'];

    protected $dates = ['deleted_at']; // Specify that 'deleted_at' is a date field.

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

