<?php

namespace App\Http\Controllers;

use App\Models\FunkoGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $request->file('image')->store('public/gallery');

        FunkoGallery::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $path,
        ]);

        return redirect()->route('gallery.index')->with('success', 'Funko Pop added to the gallery!');
    }
}

