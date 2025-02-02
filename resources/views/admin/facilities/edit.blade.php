@extends('layouts.admin')

@section('title', 'Edit Fasilitas')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-semibold mb-4">Edit Fasilitas</h1>
        <form action="{{ route('admin.facilities.update', $facility->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-lg font-medium text-gray-700">Nama Fasilitas</label>
                <input type="text" name="name" id="name" value="{{ $facility->name }}"
                    class="mt-1 block w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="category_id" class="block text-lg font-medium text-gray-700">Kategori</label>
                <select name="category_id" id=" category_id"
                    class="mt-1 block w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $facility->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="price" class="block text-lg font-medium text-gray-700">Harga</label>
                <input type="number" name="price" id="price" value="{{ $facility->price }}"
                    class="mt-1 block w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('price')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-lg font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" id="description"
                    class="mt-1 block w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ $facility->description }}</textarea>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="image" class="block text-lg font-medium text-gray-700">Gambar</label>
                <input type="file" name="image" id="image"
                    class="mt-1 block w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('image')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
                @if ($facility->image)
                    <p class="mt-2 text-gray-600">Gambar Saat Ini:</p>
                    <img src="{{ asset($facility->image) }}" alt="{{ $facility->name }}" class="mt-2 w-48">
                @endif

            </div>

            <button type="submit"
                class="w-full py-3 px-6 bg-green-500 text-white rounded-md hover:bg-green-600">Simpan</button>
        </form>
    </div>
@endsection

@if ($errors->any())
    <script>
        // set waktu refresh 1 detik
        setTimeout(() => {
            window.location.reload();
        }, 1000); // Refresh halaman setelah 1 detik
    </script>
@endif
