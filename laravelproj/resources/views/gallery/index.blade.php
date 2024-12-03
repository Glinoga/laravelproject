@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-semibold mb-8 text-center text-gray-800">Community Gallery</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($galleryItems as $item)
        <div class="bg-white shadow-lg rounded-lg overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl">
            <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->title }}" class="w-full h-56 object-cover rounded-t-lg">
            <div class="p-4">
                <h2 class="text-xl font-bold text-gray-800 hover:text-indigo-500 transition duration-200">{{ $item->title }}</h2>
                <p class="text-sm text-gray-500 mt-1">By: {{ $item->user->name }}</p>
                <p class="text-gray-700 mt-2">{{ Str::limit($item->description, 100) }}</p>
            </div>
            <div class="px-4 py-2 bg-gray-100 text-right">
                <a href="#" class="text-indigo-600 hover:text-indigo-800 text-sm">Read more...</a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $galleryItems->links() }}
    </div>
</div>
@endsection
