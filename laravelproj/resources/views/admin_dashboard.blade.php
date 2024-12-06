<!-- resources/views/admin_dashboard.blade.php -->

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
                    <a href="#" class="flex items-center py-2 px-4 hover:bg-indigo-600 text-white rounded-lg transition-all duration-200">
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

        <!-- Main content -->
        <div class="flex-1 p-6">
            <!-- Dashboard Content -->
            <h1 class="text-4xl font-bold text-gray-800">Welcome to the Admin Dashboard</h1>

            <!-- Funko Creation Form -->
            <div id="createFunkoModal" class="mt-8">
                <h2 class="text-2xl font-semibold mb-4">Create a New Funko Pop</h2>
                <form action="{{ route('funko.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="name" class="block text-gray-700">Name</label>
    <input type="text" name="name" class="form-input mt-1 block w-full" required>

    <label for="description" class="block text-gray-700 mt-3">Description</label>
    <textarea name="description" class="form-textarea mt-1 block w-full" required></textarea>

    <label for="sold_out" class="block text-gray-700 mt-3">Sold Out</label>
    <input type="checkbox" name="sold_out" class="mt-1">

    <label for="image" class="block text-gray-700 mt-3">Image</label>
    <input type="file" name="image" class="mt-1 block w-full" accept="image/*">

    <button type="submit" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg">Add Funko</button>
</form>
            </div>

            <!-- Display Funkos -->
            <div class="mt-8">
            <h2 class="mt-8 text-2xl font-semibold text-gray-700">Funko Pops</h2>
    <ul class="mt-4 space-y-4">
        @foreach ($funkos as $funko)
            <li class="bg-white p-4 shadow rounded-lg">
                <h3 class="text-xl font-bold">{{ $funko->name }}</h3>
                <p>{{ $funko->description }}</p>
                <img src="{{ $funko->image_url }}" alt="{{ $funko->name }}" class="mt-4 w-32 h-32 object-cover rounded-lg">
                <p class="text-sm text-gray-500 mt-2">{{ $funko->sold_out ? 'Sold Out' : 'Available' }}</p>
            </li>
        @endforeach
                </ul>
            </div>
        </div>
    </div>

</body>
</html>
