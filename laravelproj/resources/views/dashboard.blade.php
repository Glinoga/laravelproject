@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Got Funko Collections') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header for the Funkos collection -->
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">
                Got Funko Collections
            </h2>

            <!-- Tabs for filtering -->
            <div class="flex space-x-6 mb-6 justify-center">
                <button id="allFunkos" class="px-6 py-3 bg-indigo-600 text-white rounded-lg focus:outline-none hover:bg-indigo-700 transition-all duration-200 w-full sm:w-auto">All Funkos</button>
                <button id="availableFunkos" class="px-6 py-3 bg-indigo-600 text-white rounded-lg focus:outline-none hover:bg-indigo-700 transition-all duration-200 w-full sm:w-auto">Available</button>
                <button id="soldOutFunkos" class="px-6 py-3 bg-indigo-600 text-white rounded-lg focus:outline-none hover:bg-indigo-700 transition-all duration-200 w-full sm:w-auto">Sold Out</button>
            </div>

            <!-- Funko Gallery -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="funkoGrid">
                    @foreach ($funkos as $funko)
                        <div class="funko-card bg-white p-4 shadow-lg rounded-lg {{ $funko->sold_out ? 'bg-gray-200 opacity-50' : '' }} transition-all duration-200" data-id="{{ $funko->id }}">
                            <img src="{{ $funko->image_url }}" alt="{{ $funko->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
                            <h3 class="text-xl font-semibold text-gray-800">{{ $funko->name }}</h3>
                            <p class="text-gray-600">{{ $funko->description }}</p>
                            <p class="mt-2 text-sm text-gray-500">{{ $funko->sold_out ? 'Sold Out' : 'Available' }}</p>
                        </div>
                    @endforeach
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
                } else if (status === 'available' && !funko.classList.contains('bg-gray-200')) {
                    funko.style.display = 'block';  // Show only available Funkos
                } else if (status === 'soldOut' && funko.classList.contains('bg-gray-200')) {
                    funko.style.display = 'block';  // Show only sold-out Funkos
                } else {
                    funko.style.display = 'none';  // Hide others
                }
            });
        }
    </script>

@endsection
