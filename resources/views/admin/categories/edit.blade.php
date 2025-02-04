@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-semibold mb-4">Edit Kategori</h1>
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-lg font-medium text-gray-700">Nama Kategori</label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                    class="mt-1 block w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
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
