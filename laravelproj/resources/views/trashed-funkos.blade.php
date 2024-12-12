<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trashed Funkos</title>
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

    /* Sidebar styles (redundant) */
    .sidebar {
      display: none; /* Hide the sidebar completely */
    }

    /* Rest of your styles (unchanged) */
    .funko-card:hover {
      transform: scale(1.05);
      transition: transform 0.2s ease-in-out;
    }

    .funko-card img {
      max-height: 200px;
      object-fit: cover;
    }

    .modal {
      display: none; /* Hidden by default */
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgb(0,0,0); 
      background-color: rgba(0,0,0,0.4); 
      padding-top: 60px;
    }

    .modal-content {
      background-color: #fefefe;
      margin: 5% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
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

    <h1 class="text-4xl font-bold text-gray-800">Trashed Funkos</h1>

    <div class="mt-8">
     
      <div class="grid grid-cols-1 sm:grid>
    <h2 class="text-2xl font-semibold text-gray-700">Here are the Trashed Funkos</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-4">
        @foreach ($trashedFunkos as $funko)
            @if ($funko->trashed()) <!-- Display only trashed Funkos -->
                <div class="funko-card bg-white p-4 shadow rounded-lg opacity-50">
                    <img src="{{ $funko->image_url }}" alt="{{ $funko->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
                    <h3 class="text-xl font-semibold">{{ $funko->name }}</h3>
                    <p class="text-gray-600">{{ $funko->description }}</p>
                    <p class="mt-2 text-sm text-gray-500">Trashed</p>

                    <!-- Restore Button -->
                    <form action="{{ route('admin.restoreFunko', $funko->id) }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-lg">Restore</button>
                    </form>

                    <!-- Permanent Delete Button -->
                    <form action="{{ route('admin.permanentlyDelete', $funko->id) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg w-full sm:w-auto">Permanently Delete</button>
                    </form>
                </div>
            @endif
        @endforeach
                </div>

        {{ $trashedFunkos->links() }}
    </div>
</body>
</html>