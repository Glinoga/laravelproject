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
    $trashedFunkos = Funko::onlyTrashed()->paginate(6);

    return view('admin_dashboard', compact('funkos', 'trashedFunkos'));
}
public function trashedFunkos()
{
    $trashedFunkos = Funko::onlyTrashed()->paginate(6);// Adjust pagination as needed

    return view('trashed-funkos', compact('trashedFunkos'));
}
public function softDelete($id)
{
    $funko = Funko::findOrFail($id);
    $funko->delete();

    return redirect()->route('admin_dashboard')->with('success', 'Funko has been deleted.');
}

public function restore($id)
{
    $funko = Funko::withTrashed()->findOrFail($id);
    $funko->restore();

    return redirect()->route('admin_dashboard')->with('success', 'Funko has been restored.');
}

public function permanentlyDelete($id)
{
    $funko = Funko::withTrashed()->findOrFail($id);
    $funko->forceDelete();

    return redirect()->route('admin_dashboard')->with('success', 'Funko has been permanently deleted.');
}
}