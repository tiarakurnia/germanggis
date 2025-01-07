<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <!-- Sidebar -->
    <div class="flex flex-col md:flex-row">
        <div class="w-full md:w-1/5 bg-gray-800 h-screen text-white">
            <div class="p-4 flex justify-center items-center bg-gray-900">
                <h1 class="text-lg font-bold">Admin Panel</h1>
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

                    <!-- Kategori Menu Item -->
                    <li class="p-3 hover:bg-gray-700 rounded-md">
                        <a href="{{ route('admin.categories.index') }}" class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7-7 7 7M3 16l7 7 7-7" />
                            </svg>
                            <span>Kategori</span>
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
                        <a href="#" class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Users</span>
                        </a>
                    </li>

                    <!-- Logout Menu Item -->
                    <li class="p-3 hover:bg-gray-700 rounded-md">
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="flex items-center space-x-2">
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

</html>
