@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Available Funkopops') }}
        </h2>
    </x-slot>

    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($funkos as $funko)
                    <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                        <img src="{{ $funko->image_url }}" alt="{{ $funko->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
                        <h3 class="text-xl font-semibold">{{ $funko->name }}</h3>
                        <p class="text-gray-600">{{ $funko->description }}</p>
                        <p class="mt-2 text-sm text-gray-500">{{ $funko->sold_out ? 'Sold Out' : 'Available' }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
