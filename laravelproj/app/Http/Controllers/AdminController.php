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
        $funkos = Funko::paginate(6);

        // Return the admin dashboard view with the Funkos
        return view('admin_dashboard', compact('funkos'));
    }

    // In AdminController.php

public function toggleSoldOut(Request $request, $id)
{
    // Find the Funko by ID
    $funko = Funko::findOrFail($id);

    // Toggle the sold_out status
    $funko->sold_out = !$funko->sold_out;
    $funko->save();

    // Return the updated status as a JSON response
    return response()->json(['sold_out' => $funko->sold_out]);
}


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
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

    public function edit($id)
    {
        // Fetch the Funko to edit
        $funko = Funko::findOrFail($id);
    
        // Check if the Funko is sold out
        if ($funko->sold_out) {
            return redirect()->route('admin.gallery')->with('error', 'Cannot edit a sold-out Funko!');
        }
    
        // Return the edit view with the Funko data
        return view('admin.edit', compact('funko'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
    
        // Find the Funko to update
        $funko = Funko::findOrFail($id);
    
        // Prevent updating a sold-out Funko
        if ($funko->sold_out) {
            return redirect()->route('admin.gallery')->with('error', 'Cannot update a sold-out Funko!');
        }
    
        // Update Funko details
        $funko->name = $request->name;
        $funko->description = $request->description;
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('funkos', 'public');
            $funko->image = $imagePath;
        }
    
        // Save changes
        $funko->save();
    
        return redirect()->route('admin_dashboard')->with('success', 'Funko updated successfully!');
    }
}
