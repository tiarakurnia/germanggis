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
                        <a href="{{ route('admin.facilities.edit', $facility->id) }}" class="text-blue-500">
                            <i class="fas fa-edit"></i> <!-- Ikon Edit -->
                        </a>
                        <button class="text-red-500 delete-facility" data-id="{{ $facility->id }}">
                            <i class="fas fa-trash-alt"></i> <!-- Ikon Hapus -->
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('admin.facilities.create') }}"
        class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">Tambah Fasilitas</a>

    <!-- Form Global untuk Menghapus Data -->
    <form id="delete-form" action="" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
@endsection


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tangkap semua tombol hapus
        const deleteButtons = document.querySelectorAll('.delete-facility');
        const deleteForm = document.getElementById('delete-form');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const facilityId = this.getAttribute('data-id');
                const deleteUrl = `{{ route('admin.facilities.destroy', '') }}/${facilityId}`;

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang sudah dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteForm.action = deleteUrl;
                        deleteForm.submit();
                    }
                });
            });
        });
    });
</script>
