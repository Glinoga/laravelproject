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
        /* Card hover effect */
        .funko-card:hover {
            transform: scale(1.05);
            transition: transform 0.2s ease-in-out;
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

        <!-- Main content -->
        <div class="flex-1 p-6">
            <!-- Dashboard Content -->
            <h1 class="text-4xl font-bold text-gray-800">Welcome to the Admin Dashboard</h1>

            <!-- Funko Creation Form -->
            <div id="createFunkoModal" class="mt-8">
                <h2 class="text-2xl font-semibold mb-4">Create a New Funko Pop</h2>
                <form action="{{ route('funko.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Name Input -->
                    <label for="name" class="block text-gray-700">Name</label>
                    <input type="text" name="name" class="form-input mt-1 block w-full" value="{{ old('name') }}">
                    @error('name')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror

                    <!-- Description Input -->
                    <label for="description" class="block text-gray-700 mt-3">Description</label>
                    <textarea name="description" class="form-textarea mt-1 block w-full">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror

                    <!-- Image Input -->
                    <label for="image" class="block text-gray-700 mt-3">Image</label>
                    <input type="file" name="image" class="mt-1 block w-full" accept="image/*">
                    @error('image')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror

                    <!-- Submit Button -->
                    <button type="submit" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg">Add Funko</button>
                </form>
            </div>

            <!-- Funkos Tabs -->
            <div class="mt-4">
                <h2 class="text-2xl font-semibold text-gray-700">Funko Pops</h2>
                <div class="mt-8">
                    <!-- Tabs for filtering -->
                    <div class="flex space-x-6 mb-6 justify-center">
                        <button id="allFunkos" class="px-6 py-3 bg-indigo-600 text-white rounded-lg focus:outline-none hover:bg-indigo-700 transition-all duration-200">All Funkos</button>
                        <button id="availableFunkos" class="px-6 py-3 bg-indigo-600 text-white rounded-lg focus:outline-none hover:bg-indigo-700 transition-all duration-200">Available</button>
                        <button id="soldOutFunkos" class="px-6 py-3 bg-indigo-600 text-white rounded-lg focus:outline-none hover:bg-indigo-700 transition-all duration-200">Sold Out</button>
                    </div>

                    <!-- Funko Gallery -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-4" id="funkoGrid">
                        @foreach ($funkos as $funko)
                            <div class="funko-card bg-white p-4 shadow rounded-lg {{ $funko->sold_out ? 'bg-gray-200 opacity-50 sold-out' : 'available' }}" data-id="{{ $funko->id }}">
                                <img src="{{ $funko->image_url }}" alt="{{ $funko->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
                                <h3 class="text-xl font-semibold">{{ $funko->name }}</h3>
                                <p class="text-gray-600">{{ $funko->description }}</p>
                                <p class="mt-2 text-sm text-gray-500">{{ $funko->sold_out ? 'Sold Out' : 'Available' }}</p>
                                <button class="sold-out-btn mt-2 px-4 py-2 bg-indigo-600 text-white rounded-lg {{ $funko->sold_out ? 'opacity-50 cursor-not-allowed' : '' }}">
                                    {{ $funko->sold_out ? 'Sold Out' : 'Mark as Sold Out' }}
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $funkos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Handle Tab Switching
        document.getElementById('allFunkos').addEventListener('click', function() {
            filterFunkos('all');
        });
        document.getElementById('availableFunkos').addEventListener('click', function() {
            filterFunkos('available');
        });
        document.getElementById('soldOutFunkos').addEventListener('click', function() {
            filterFunkos('soldOut');
        });

        function filterFunkos(status) {
            const allFunkos = document.querySelectorAll('.funko-card');
            allFunkos.forEach((funko) => {
                if (status === 'all') {
                    funko.style.display = 'block';  // Show all Funkos
                } else if (status === 'available' && !funko.classList.contains('sold-out')) {
                    funko.style.display = 'block';  // Show only available Funkos
                } else if (status === 'soldOut' && funko.classList.contains('sold-out')) {
                    funko.style.display = 'block';  // Show only sold-out Funkos
                } else {
                    funko.style.display = 'none';  // Hide others
                }
            });
        }

        // Handle Sold Out Button click with AJAX
        document.querySelectorAll('.sold-out-btn').forEach(button => {
            button.addEventListener('click', function() {
                const funkoCard = this.closest('.funko-card');
                const funkoId = funkoCard.getAttribute('data-id');

                fetch(`/admin/funko/${funkoId}/toggle-sold-out`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({}),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.sold_out) {
                        funkoCard.classList.add('bg-gray-200', 'opacity-50', 'sold-out');
                        this.classList.add('opacity-50', 'cursor-not-allowed');
                        this.innerText = 'Sold Out';
                    } else {
                        funkoCard.classList.remove('bg-gray-200', 'opacity-50', 'sold-out');
                        this.classList.remove('opacity-50', 'cursor-not-allowed');
                        this.innerText = 'Mark as Sold Out';
                    }

                    // Reapply filters after the toggle
                    filterFunkos(document.querySelector('button[style*="background-color: #1E40AF"]').innerText.toLowerCase());
                });
            });
        });
    </script>

</body>
</html>
