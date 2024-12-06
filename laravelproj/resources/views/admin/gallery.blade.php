<!-- resources/views/admin/gallery.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite('resources/css/app.css')
    <style>
        /* Sidebar style */
        .sidebar {
            background-color: #1E40AF; /* Blue background */
            color: white; /* White text */
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1); /* Optional: add a shadow for effect */
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Admin Sidebar -->
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 sidebar p-6 min-h-screen">
            <h2 class="text-3xl font-semibold mb-8 text-white">Admin Dashboard</h2>

            <ul class="space-y-6">
                <li>
                    <a href="{{ route('admin_dashboard') }}" class="flex items-center py-2 px-4 hover:bg-indigo-600 text-white rounded-lg transition-all duration-200">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.gallery') }}" class="flex items-center py-2 px-4 hover:bg-indigo-600 text-white rounded-lg transition-all duration-200">
                        Gallery
                    </a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center py-2 px-4 hover:bg-indigo-600 text-white rounded-lg w-full text-left transition-all duration-200">
                            Log Out
                        </button>
                    </form>
                </li>
            </ul>

            
        </div>
    <div class="container">
        <h1 class="text-2xl font-bold mb-6">Admin Gallery</h1>

        <!-- Success message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-3 gap-6">
            @foreach($funkos as $funko)
                <div class="bg-white p-4 shadow rounded-lg">
                    <h3 class="text-xl font-bold">{{ $funko->title }}</h3>
                    <p>{{ $funko->description }}</p>
                    <img src="{{ asset('storage/' . $funko->image_path) }}" alt="{{ $funko->name }}" class="mt-4 w-32 h-32 object-cover rounded-lg">

                    <!-- Display different buttons based on the Funko's status -->
                    @if($funko->deleted_at)
                        <div class="mt-4">
                            <!-- Restore Button -->
                            <form action="{{ route('admin.restore', $funko->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-lg">Restore</button>
                            </form>
                            <!-- Permanently Delete Button -->
                            <form action="{{ route('admin.permanentDelete', $funko->id) }}" method="POST" class="inline ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg">Delete Permanently</button>
                            </form>
                        </div>
                    @else
                        <!-- Soft Delete Button -->
                        <form action="{{ route('admin.softDelete', $funko->id) }}" method="POST" class="mt-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg">Delete</button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</html>
