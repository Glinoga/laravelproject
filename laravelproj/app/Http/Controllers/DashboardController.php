<?php

// app/Http/Controllers/DashboardController.php
// DashboardController.php
namespace App\Http\Controllers;

use App\Models\Funko;

class DashboardController extends Controller
{
    public function index()
{
    $funkos = Funko::paginate(6); // Or use any logic to get the Funkos

    return view('dashboard', compact('funkos'));
}
}


