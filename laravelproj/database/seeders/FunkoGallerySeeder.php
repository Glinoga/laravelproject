<?php

namespace Database\Seeders;

use App\Models\FunkoGallery;
use Illuminate\Database\Seeder;

class FunkoGallerySeeder extends Seeder
{
    public function run()
    {
        FunkoGallery::create([
            'user_id' => 1, // Replace with an actual user ID
            'title' => 'Funko Pop 1',
            'description' => 'Description of Funko Pop 1',
            'image_path' => 'path/to/image1.jpg',
        ]);

        FunkoGallery::create([
            'user_id' => 1, // Replace with an actual user ID
            'title' => 'Funko Pop 2',
            'description' => 'Description of Funko Pop 2',
            'image_path' => 'path/to/image2.jpg',
        ]);
    }
}
