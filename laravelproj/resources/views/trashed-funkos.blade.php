<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trashed Funkos</title>
    </head>
<body>
    <div class="mt-8">
        <h1 class="text-3xl font-bold mb-4">Trashed Funkos</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($trashedFunkos as $funko)
                <div class="bg-white p-4 rounded-lg shadow-md">
                <img src="{{ $funko->image_url }}" alt="{{ $funko->name }}" class="w-full max-h-32 object-cover rounded-lg mb-4">
                    <h2 class="text-xl font-bold">{{ $funko->name }}</h2>
                    <p class="text-gray-700">{{ $funko->description }}</p>

                    <form action="{{ route('admin.restoreFunko', $funko->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Restore</button>
                    </form>

                    <form action="{{ route('admin.permanentlyDelete', $funko->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Permanent Delete</button>
                    </form>
                </div>
            @endforeach
        </div>

        {{ $trashedFunkos->links() }}
    </div>
</body>
</html>