@extends('layouts.app')

@section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-semibold mb-4">Edit Funko Pop - {{ $funko->name }}</h2>

                <!-- Display Success Message if Funko is updated -->
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-500 text-white rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('funko.update', $funko->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Name Input -->
                    <label for="name" class="block text-gray-700">Name</label>
                    <input type="text" name="name" class="form-input mt-1 block w-full" value="{{ old('name', $funko->name) }}" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror

                    <!-- Description Input -->
                    <label for="description" class="block text-gray-700 mt-3">Description</label>
                    <textarea name="description" class="form-textarea mt-1 block w-full" required>{{ old('description', $funko->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror

                    <!-- Current Image Display -->
                    <div class="mt-3">
                        <label for="current-image" class="block text-gray-700">Current Image</label>
                        <img src="{{ asset('storage/' . $funko->image_url) }}" alt="{{ $funko->name }}" class="w-48 h-48 object-cover rounded-lg mt-2">
                    </div>

                    <!-- Image Input (Optional) -->
                    <label for="image" class="block text-gray-700 mt-3">New Image (optional)</label>
                    <input type="file" name="image" class="mt-1 block w-full" accept="image/*">
                    @error('image')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror

                    <!-- Submit Button -->
                    <button type="submit" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg">Update Funko</button>
                </form>

                <!-- Go back to Dashboard Button -->
                <div class="mt-4">
                    <a href="{{ route('admin_dashboard') }}" class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all duration-200">
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
