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
                <button id="allFunkos" class="px-6 py-3 bg-black text-white rounded-lg focus:outline-none hover:bg-gray-500 transition-all duration-200 w-full sm:w-auto">All Funkos</button>
                <button id="availableFunkos" class="px-6 py-3 bg-black text-white rounded-lg focus:outline-none hover:bg-gray-500 transition-all duration-200 w-full sm:w-auto">Available</button>
                <button id="soldOutFunkos" class="px-6 py-3 bg-black text-white rounded-lg focus:outline-none hover:bg-gray-500 transition-all duration-200 w-full sm:w-auto">Sold Out</button>
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

                    <!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg w-96">
        <h3 class="text-xl font-semibold mb-4">Edit Funko Pop</h3>
        <form id="editFunkoForm" action="{{ route('funko.update', 'funko_id') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Name Input -->
            <label for="name" class="block text-gray-700">Name</label>
            <input type="text" name="name" id="editName" class="form-input mt-1 block w-full" required>
            
            <!-- Description Input -->
            <label for="description" class="block text-gray-700 mt-3">Description</label>
            <textarea name="description" id="editDescription" class="form-textarea mt-1 block w-full" required></textarea>

            <!-- Image Input -->
            <label for="image" class="block text-gray-700 mt-3">Image</label>
            <input type="file" name="image" id="editImage" class="mt-1 block w-full" accept="image/*">

            <!-- Submit Button -->
            <button type="submit" class="mt-4 px-4 py-2 bg-black text-white rounded-lg">Save Changes</button>
        </form>
        <button id="closeModal" class="mt-2 px-4 py-2 bg-red-600 text-white rounded-lg">Close</button>
    </div>
</div>

                </div>
            </div>
        </div>
    </div>

    <script>
        // Open Edit Modal
document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function () {
        const funkoId = this.getAttribute('data-id');
        const funkoName = this.getAttribute('data-name');
        const funkoDescription = this.getAttribute('data-description');
        const funkoImage = this.getAttribute('data-image');

        // Set form action URL dynamically for the correct Funko
        const form = document.getElementById('editFunkoForm');
        form.action = `/admin/funko/${funkoId}`;

        // Set the modal form fields
        document.getElementById('editName').value = funkoName;
        document.getElementById('editDescription').value = funkoDescription;
        document.getElementById('editImage').value = '';  // Reset image field

        // Show the modal
        document.getElementById('editModal').classList.remove('hidden');
    });
});

// Close Modal
document.getElementById('closeModal').addEventListener('click', function () {
    document.getElementById('editModal').classList.add('hidden');
});

// AJAX Form Submission for Editing
document.getElementById('editFunkoForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Funko updated successfully!');
            window.location.reload(); // Reload the page to see the changes
        } else {
            alert('Error updating Funko');
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
});



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
