<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  @vite('resources/css/app.css')
  <style>
    /* Navbar styles */
    .navbar {
      background-color: black;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 2rem;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 10; /* Ensure navbar stays on top */
    }

    .navbar a {
      color: white;
      text-decoration: none;
      padding: 0.5rem 1rem;
    }

    .navbar a:hover {
      background-color: #292929;
      transition: background-color 0.2s ease-in-out;
    }

    /* Main content styles */
    .main-content {
      padding: 1rem;
      margin-top: 60px; /* Account for navbar height */
    }
  </style>
</head>
<body class="bg-gray-100">

  <div class="navbar">
    <h2 class="text-xl font-semibold text-white">Admin Dashboard</h2>
    <ul class="flex space-x-4">
      <li>
        <a href="{{ route('admin_dashboard') }}">Dashboard</a>
      </li>
      <li>
        <a href="{{ route('admin.gallery') }}">Gallery</a>
      </li>
      <li>
        <a href="{{ route('trashed.funkos') }}">Trashed Funkos</a>
      </li>
      <li>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="text-white hover:underline">Log Out</button>
        </form>
      </li>
    </ul>
  </div>

  <div class="main-content">

    <h1 class="text-4xl font-bold text-gray-800">Welcome to the Admin Dashboard</h1>

    <div id="createFunkoModal" class="mt-8">
      <h2 class="text-2xl font-semibold mb-4">Create a New Funko Pop</h2>
      <form action="{{ route('funko.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="name" class="block text-gray-700">Name</label>
        <input type="text" name="name" class="form-input mt-1 block w-full" value="{{ old('name') }}">
        @error('name')
          <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror

        <label for="description" class="block text-gray-700 mt-3">Description</label>
        <textarea name="description" class="form-textarea mt-1 block w-full">{{ old('description') }}</textarea>
        @error('description')
          <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror

        <label for="image" class="block text-gray-700 mt-3">Image</label>
        <input type="file" name="image" class="mt-1 block w-full" accept="image/*">
        @error('image')
          <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror

        <button type="submit" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg">Add Funko</button>
      </form>
    </div>

  

            <!-- Funkos Tabs -->
            <div class="mt-4">
                <h2 class="text-2xl font-semibold text-gray-700">Funko Pops</h2>
                
@if (session('success'))
<div class="container mx-auto px-4 py-4">
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded-md shadow">
        {{ session('success') }}
    </div>
</div>
@endif
                <div class="mt-8">

                    <!-- Tabs for filtering -->
                    <div class="flex space-x-6 mb-6 justify-center">
                        <button id="allFunkos" class="px-6 py-3 bg-indigo-600 text-white rounded-lg focus:outline-none hover:bg-indigo-700 transition-all duration-200 w-full sm:w-auto">All Funkos</button>
                        <button id="availableFunkos" class="px-6 py-3 bg-indigo-600 text-white rounded-lg focus:outline-none hover:bg-indigo-700 transition-all duration-200 w-full sm:w-auto">Available</button>
                        <button id="soldOutFunkos" class="px-6 py-3 bg-indigo-600 text-white rounded-lg focus:outline-none hover:bg-indigo-700 transition-all duration-200 w-full sm:w-auto">Sold Out</button>
                        <button id="trashedFunkos" class="px-6 py-3 bg-indigo-600 text-white rounded-lg focus:outline-none hover:bg-indigo-700 transition-all duration-200 w-full sm:w-auto"  href="{{ route('trashed.funkos') }}">Trashed Funkos</button>
                    
                    </div>

                    <!-- Funko Gallery -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-4" id="funkoGrid">
                        @foreach ($funkos as $funko)
                            <div class="funko-card bg-white p-4 shadow rounded-lg {{ $funko->sold_out ? 'bg-gray-200 opacity-50 sold-out' : 'available' }}" data-id="{{ $funko->id }}">
                                <img src="{{ $funko->image_url }}" alt="{{ $funko->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
                                <h3 class="text-xl font-semibold">{{ $funko->name }}</h3>
                                <p class="text-gray-600">{{ $funko->description }}</p>
                                <p class="mt-2 text-sm text-gray-500">{{ $funko->sold_out ? 'Sold Out' : 'Available' }}</p>

                                <!-- Edit Button -->
                                @if (!$funko->sold_out)
                                    <a href="{{ route('funko.edit', $funko->id) }}" class="edit-btn mt-2 px-4 py-2 bg-indigo-600 text-white rounded-lg mb-2 w-full sm:w-auto block text-center">Edit Funko</a>
                                @else
                                    <button class="edit-btn mt-2 px-4 py-2 bg-indigo-600 text-white rounded-lg mb-2 w-full sm:w-auto" disabled>Edit Funko (Sold Out)</button>
                                @endif

                                <button class="sold-out-btn mt-2 px-4 py-2 bg-indigo-600 text-white rounded-lg mb-2 w-full sm:w-auto {{ $funko->sold_out ? 'opacity-50 cursor-not-allowed' : '' }}">
                                    {{ $funko->sold_out ? 'Sold Out' : 'Mark as Sold Out' }}
                                </button>
        
                                    <!-- Soft Delete Button -->
                                    <form action="{{ route('admin.softDeleteFunko', $funko->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="mt-2 px-4 py-2 bg-red-600 text-white rounded-lg w-full sm:w-auto">Delete</button>
                                    </form>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">{{ $funkos->links() }}</div>
                </div>
            </div>

                
            </div>
        </div>
    </div>

    <script>
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
                });
            });
        });

        // Handle Filtering functionality
        function filterFunkos(status) {
            const allFunkos = document.querySelectorAll('.funko-card');
            allFunkos.forEach((funko) => {
                if (status === 'all') {
                    funko.style.display = 'block';
                } else if (status === 'available' && !funko.classList.contains('sold-out')) {
                    funko.style.display = 'block';
                } else if (status === 'soldOut' && funko.classList.contains('sold-out')) {
                    funko.style.display = 'block';
                } else {
                    funko.style.display = 'none';
                }
            });
        }

        document.getElementById('allFunkos').addEventListener('click', function() {
            filterFunkos('all');
        });

        document.getElementById('availableFunkos').addEventListener('click', function() {
            filterFunkos('available');
        });

        document.getElementById('soldOutFunkos').addEventListener('click', function() {
            filterFunkos('soldOut');
        });
    </script>

</body>
</html>
