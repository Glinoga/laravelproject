<?php

namespace App\Http\Controllers;

use App\Models\Funko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FunkoController extends Controller
{
    // Show the list of Funkos (already exists)
    public function index()
    {
        // Fetch all Funkos, including soft-deleted ones
        $funkos = Funko::withTrashed()->paginate(6);
        $trashedFunkos = Funko::onlyTrashed()->paginate(6);
        
        return view('admin_dashboard', compact('funkos'));
    }

    public function softDelete($id)
    {
        // Soft delete the Funko by ID
        $funko = Funko::findOrFail($id);
        $funko->delete();
    
        // Redirect with success message
        return redirect()->route('admin_dashboard')->with('success', 'Funko has been deleted.');
    }
    
    public function restore($id)
    {
        // Restore the Funko
        $funko = Funko::withTrashed()->findOrFail($id);
        $funko->restore();
    
        // Redirect with success message
        return redirect()->route('admin_dashboard')->with('success', 'Funko has been restored.');
    }
    
    public function permanentlyDelete($id)
    {
        // Permanently delete the Funko
        $funko = Funko::withTrashed()->findOrFail($id);
        $funko->forceDelete();
    
        // Redirect with success message
        return redirect()->route('admin_dashboard')->with('success', 'Funko has been permanently deleted.');
    }
    

    // Edit the Funko (already exists)
    public function edit($id)
    {
        // Find the Funko by ID
        $funko = Funko::findOrFail($id);

        // Return the edit view with the Funko details
        return view('admin.edit', compact('funko'));
    }

    // Update the Funko (already exists)
    public function update(Request $request, $id)
    {
        // Find the Funko by ID
        $funko = Funko::findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Update the Funko
        $funko->name = $validated['name'];
        $funko->description = $validated['description'];

        // Handle image upload if present
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/funkos');
            $funko->image_url = $imagePath;
        }

        // Save the updated Funko
        $funko->save();

        // Redirect back with a success message
        return redirect()->route('admin_dashboard')->with('success', 'Funko has been updated.');
    }
}
