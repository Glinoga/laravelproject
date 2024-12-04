<?php

namespace App\Http\Controllers;

use App\Models\FunkoGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleryItems = FunkoGallery::with('user')->latest()->paginate(10);
        return view('gallery.index', compact('galleryItems'));
    }

    public function create()
    {
        return view('gallery.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Store the image
        $path = $request->file('image')->store('funko_gallery', 'public');

        // Save to database
        FunkoGallery::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image_path' => $path,
        ]);

        return redirect()->route('gallery.index')->with('success', 'Gallery item added successfully!');
    }
}

