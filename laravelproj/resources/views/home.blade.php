<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bri's Funkopops</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js for interaction -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>

    <style>
        /* Adding some custom styles for the Funko Pop carousel */
        .pop-image {
            transition: transform 0.3s ease;
        }

        .pop-image:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body class="bg-gray-50 font-sans">

    <!-- Header Section -->
    <header class="bg-white shadow-lg py-6">
        <div class="container mx-auto px-6 flex justify-between items-center">

            <!-- Logo Section -->
            <div class="text-2xl font-bold text-blue-600">
                <a href="/">
                    <img class="size-10" src="/toyhorse.svg" alt="Toy Horse" />
                </a>
            </div>

            <!-- Navigation Section -->
            <nav class="space-x-6">
                @if (Route::has('login'))
                    <div class="flex items-center space-x-6">
                        @auth
                            @if (auth()->user()->role === 'admin')
                                <a href="{{ url('admin/dashboard') }}" class="text-gray-800 font-medium hover:text-gray-600 transition duration-200">Admin Dashboard</a>
                            @else
                                <a href="{{ url('dashboard') }}" class="text-gray-800 font-medium hover:text-gray-600 transition duration-200">User Dashboard</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="text-gray-800 font-medium hover:text-gray-600 transition duration-200">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-gray-800 font-medium hover:text-gray-600 transition duration-200">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </nav>
        </div>
    </header>

    <!-- Main Content (Random Funko Pops Display) -->
    <main class="py-12">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Welcome to Bri's Funkopops</h1>
            <p class="text-lg text-gray-600 mb-8">Explore, and find a funko pop just for you! </p>

            <!-- Funko Pop Carousel/Display -->
            <div x-data="{ pops: [
                    { name: 'Batwoman', image: '{{ asset('images/batwoman.jpg') }}' },
                    { name: 'Darth Vader', image: '{{ asset('images/darthvader.jpg') }}' },
                    { name: 'Morty', image: '{{ asset('images/morty.jpg') }}' },
                ], currentPop: 0 }"
                x-init="setInterval(() => { currentPop = (currentPop + 1) % pops.length }, 6000)" class="space-y-6">

                <!-- Display Random Funko Pop -->
                <div class="flex justify-center">
                    <img :src="pops[currentPop].image" :alt="pops[currentPop].name" class="pop-image rounded-lg shadow-lg h-64">
                </div>

                <!-- Funko Pop Name -->
                <div class="text-xl font-semibold text-gray-800">
                    <span x-text="pops[currentPop].name"></span>
                </div>

            </div>
        </div>
    </main>

</body>

</html>
