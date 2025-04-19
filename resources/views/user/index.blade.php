@extends('layouts.app')

@section('title', 'Daftar Pengguna')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Pengguna</h1>
        <a href="{{ route('user.create') }}" class="flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-200 shadow-md">
            <i class="fas fa-plus mr-2"></i>
            Tambah Pengguna
        </a>
    </div>

    @if (session('success'))
    <div id="success-message" class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        {{ session('success') }}
    </div>

    <script>
        setTimeout(() => {
            document.getElementById('success-message').style.display = 'none';
        }, 3000);
    </script>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full text-sm text-gray-600">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center">ID</th>
                    <th scope="col" class="px-6 py-3 text-left">Nama</th>
                    <th scope="col" class="px-6 py-3 text-left">Email</th>
                    <th scope="col" class="px-6 py-3 text-center">Role</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 1; 
                @endphp

                @foreach ($users as $user)
                <tr class="bg-white border-b hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4 text-center font-medium text-gray-900">
                        {{ $counter++ }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ $user->name }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ $user->email }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        {{ ucfirst($user->role) }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center space-x-3">
                            <a href="{{ route('user.edit', $user) }}" class="text-blue-600 hover:text-blue-800 transition duration-200" title="Edit">
                                <i class="fas fa-edit fa-lg"></i>
                            </a>
                            <form action="{{ route('user.destroy', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 transition duration-200" title="Hapus" onclick="return confirm('Yakin ingin menghapus pengguna ini?')">
                                    <i class="fas fa-trash-alt fa-lg"></i>
                                </button>
                            </form>                            
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection