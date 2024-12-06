<?php

// app/Http/Controllers/DashboardController.php
// DashboardController.php
namespace App\Http\Controllers;

use App\Models\Funko;

class DashboardController extends Controller
{
    public function index()
{
    $funkos = Funko::all(); // Or use any logic to get the Funkos

    return view('dashboard', compact('funkos'));
}
}


