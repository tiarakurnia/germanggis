<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <!-- Sidebar -->
    <div class="flex flex-col md:flex-row">
        <div class="w-full md:w-1/5 bg-gray-800 h-screen text-white">
            <div class="p-4 flex justify-center items-center bg-gray-900">
                <h1 class="text-lg font-bold">Admin Wisata Germanggis</h1>
            </div>
            <nav class="mt-6">
                <ul>
                    <!-- Dashboard Menu Item -->
                    <li class="p-3 hover:bg-gray-700 rounded-md">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7-7 7 7M3 16l7 7 7-7" />
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- Kategori Menu Item -->

                    <li class="p-3 hover:bg-gray-700 rounded-md">
                        <a href="{{ route('admin.categories.index') }}" class="flex items-center space-x-2">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" />
                            </svg>
                            <span>Kategori</span>
                        </a>
                    </li>

                    <!-- Facilities Menu Item -->
                    <li class="p-3 hover:bg-gray-700 rounded-md">
                        <a href="{{ route('admin.facilities.index') }}" class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
                            </svg>
                            <span>Fasilitas</span>
                        </a>
                    </li>

                    <!-- Pesanan Menu Item -->
                    <li class="p-3 hover:bg-gray-700 rounded-md">
                        <a href="{{ route('admin.orders.index') }}" class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h6m-3-3v6m-7 0a9 9 0 1118 0 9 9 0 01-18 0z" />
                            </svg>
                            <span>Pesanan</span>
                        </a>
                    </li>

                    <!-- Users Menu Item -->
                    <li class="p-3 hover:bg-gray-700 rounded-md">
                        <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4 v16m8-8H4" />
                            </svg>
                            <span>Users</span>
                        </a>
                    </li>

                    <!-- Logout Menu Item -->
                    <li class="p-3 hover:bg-gray-700 rounded-md">
                        <a href="#" onclick="confirmLogout()" class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17 9l4-4m0 0l-4-4m4 4H3m10 4l-4 4m0 0l4 4m-4-4H3" />
                            </svg>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="w-full md:w-4/5 p-6">
            <div class="bg-white shadow rounded-lg p-6">
                @yield('content')
            </div>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Yakin ingin keluar?',
            text: "Anda akan keluar dari akun ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, keluar!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form logout jika dikonfirmasi
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>

</html>
