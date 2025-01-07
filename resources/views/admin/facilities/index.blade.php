@extends('layouts.admin')

@section('title', 'Fasilitas')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Fasilitas Wisata</h2>
    <table class="min-w-full table-auto">
        <thead>
            <tr>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Kategori</th>
                <th class="px-4 py-2">Harga</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($facilities as $facility)
                <tr>
                    <td class="border px-4 py-2">{{ $facility->name }}</td>
                    <td class="border px-4 py-2">{{ $facility->category->name }}</td>
                    <td class="border px-4 py-2">Rp{{ number_format($facility->price, 0, ',', '.') }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('admin.facilities.edit', $facility->id) }}" class="text-blue-500">Edit</a>
                        <form action="{{ route('admin.facilities.destroy', $facility->id) }}" method="POST"
                            class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('admin.facilities.create') }}"
        class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">Tambah Fasilitas</a>
@endsection
