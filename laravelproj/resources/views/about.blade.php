@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<header class="bg-black text-white py-4">
    <div class="container mx-auto text-center">
        <h1 class="text-3xl font-bold">About Us</h1>
    </div>
</header>

<main class="container mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-4">Contact Us</h2>
    <p class="mb-6">If you have any questions or want to get in touch, feel free to contact us through the following methods:</p>

    <div class="flex flex-col md:flex-row gap-6">
        <div class="flex items-center gap-4">
            <img src="https://img.icons8.com/ios-filled/50/000000/phone.png" alt="Phone Icon" class="w-10 h-10">
            <span class="text-lg font-medium">09266280962</span>
        </div>

        <div class="flex items-center gap-4">
            <img src="https://img.icons8.com/ios-filled/50/000000/facebook-new.png" alt="Facebook Icon" class="w-10 h-10">
            <a href="https://www.facebook.com/profile.php?id=100088628276490" target="_blank" class="text-lg font-medium text-blue-600 underline">Got Funko Collections</a>
        </div>

        <div class="flex items-center gap-4">
            <img src="https://img.icons8.com/ios-filled/50/000000/email.png" alt="Email Icon" class="w-10 h-10">
            <a href="mailto:owner@example.com" class="text-lg font-medium text-blue-600 underline">brianpope@gmail.com</a>
        </div>
    </div>
</main>

<footer class="bg-black text-white py-4 mt-10">
    <div class="container mx-auto text-center">
        <p>&copy; 2024 Funko Haven. All Rights Reserved.</p>
    </div>
</footer>
@endsection
