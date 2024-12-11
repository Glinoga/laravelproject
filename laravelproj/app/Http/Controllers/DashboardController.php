<?php

// app/Http/Controllers/DashboardController.php
// DashboardController.php
namespace App\Http\Controllers;

use App\Models\Funko;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
{
    $user = Auth::user();

    if ($user && $user->is_admin) {
        return redirect()->route('admin_dashboard');
    }
    
    $funkos = Funko::paginate(6); // Or use any logic to get the Funkos

    return view('dashboard', compact('funkos'));
}
}


