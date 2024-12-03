<x-app-layout>

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-4">Add a Funko Pop</h1>

    <form method="POST" action="{{ route('gallery.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700">Title</label>
            <input type="text" name="title" class="w-full p-2 border rounded-md" value="{{ old('title') }}">
            @error('title') <p class="text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Description</label>
            <textarea name="description" class="w-full p-2 border rounded-md">{{ old('description') }}</textarea>
            @error('description') <p class="text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Image</label>
            <input type="file" name="image" class="w-full p-2">
            @error('image') <p class="text-red-600">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add Funko Pop</button>
    </form>
</div>
</x-app-layout>
