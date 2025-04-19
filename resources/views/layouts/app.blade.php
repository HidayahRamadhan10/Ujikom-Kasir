<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Admin')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
</head>

<body class="bg-gray-100 font-inter">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-52 bg-blue-900 text-white h-full flex-shrink-0">

            <div class="flex items-center justify-between p-4 border-b border-gray-800">
                <h2 class="text-2xl font-bold">Kasir UKK</h2>
            </div>
            <nav class="mt-4">
                <a href="{{ route('dashboard') }}" class="group flex items-center px-4 py-3 hover:bg-gray-800 transition duration-200 {{ request()->routeIs('dashboard') ? 'bg-gray-800 text-blue-400' : 'text-gray-300' }}">
                    <i class="fas fa-home mr-3 group-hover:text-blue-400"></i>Dashboard
                </a>
                <a href="{{ route('product.index') }}" class="group flex items-center px-4 py-3 hover:bg-gray-800 transition duration-200 {{ request()->routeIs('product.*') ? 'bg-gray-800 text-blue-400' : 'text-gray-300' }}">
                    <i class="fas fa-store mr-3 group-hover:text-blue-400"></i>Produk
                </a>
                <a href="{{ route('pembelian.index') }}" class="group flex items-center px-4 py-3 hover:bg-gray-800 transition duration-200 {{ request()->routeIs('pembelian.*') ? 'bg-gray-800 text-blue-400' : 'text-gray-300' }}">
                    <i class="fas fa-cash-register mr-3 group-hover:text-blue-400"></i>Pembelian
                </a>
                @if (Auth::user() && Auth::user()->role === 'admin')
                    <a href="{{ route('user.index') }}" class="group flex items-center px-4 py-3 hover:bg-gray-800 transition duration-200 {{ request()->routeIs('users.*') ? 'bg-gray-800 text-blue-400' : 'text-gray-300' }}">
                        <i class="fas fa-user-cog mr-3 group-hover:text-blue-400"></i>Pengguna
                    </a>
                @endif
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm px-6 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-xl font-semibold text-gray-800">@yield('title')</h1>
                    
                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <!-- Tombol profil -->
                        <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2 focus:outline-none">
                            <img src="{{ asset('img/profil.png') }}" alt="Profil" class="h-8 w-8 rounded-full object-cover">
                        </button>
                    
                        <!-- Dropdown menu -->
                        <div x-show="dropdownOpen"
                             @click.away="dropdownOpen = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-50">
                    
                            <!-- Menampilkan nama user yang login -->
                            <div class="px-4 py-2">
                                <span class="text-gray-700 font-semibold">{{ Auth::user()->name }}</span>
                            </div>
                    
                            <div class="border-t border-gray-200"></div> <!-- Pemisah antara nama dan logout -->
                    
                            <!-- Tombol logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>