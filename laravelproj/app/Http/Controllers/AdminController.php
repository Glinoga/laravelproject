<?php

// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funko;
use App\Models\FunkoGallery;

class AdminController extends Controller
{
    public function index()
    {
        // Fetch all Funkos
        $funkos = Funko::all();

        // Return the admin dashboard view with the Funkos
        return view('admin_dashboard', compact('funkos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'sold_out' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('funkos', 'public');
        } else {
            $imagePath = null;
        }

        Funko::create([
            'name' => $request->name,
            'description' => $request->description,
            'sold_out' => $request->sold_out ?? false,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin_dashboard');
    }

    public function gallery()
    {
        // Fetch all Funko posts, including soft-deleted ones
        $funkos = FunkoGallery::withTrashed()->get();

        return view('admin.gallery', compact('funkos'));
    }

    public function softDelete($id)
    {
        // Soft delete the Funko post
        $funko = FunkoGallery::findOrFail($id);
        $funko->delete();

        return redirect()->route('admin.gallery')->with('success', 'Funko post has been deleted.');
    }

    public function restore($id)
    {
        // Restore a soft-deleted Funko post
        $funko = FunkoGallery::withTrashed()->findOrFail($id);
        $funko->restore();

        return redirect()->route('admin.gallery')->with('success', 'Funko post has been restored.');
    }

    public function permanentDelete($id)
    {
        // Permanently delete the Funko post
        $funko = FunkoGallery::withTrashed()->findOrFail($id);
        $funko->forceDelete();

        return redirect()->route('admin.gallery')->with('success', 'Funko post has been permanently deleted.');
    }
}

