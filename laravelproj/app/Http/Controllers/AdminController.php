<?php

// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funko;

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
}

