<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-semibold mb-4">
                        Daftar User
                    </h3>

                    {{-- Search & Filter --}}
                    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-6">
                        <div class="flex flex-col sm:flex-row gap-2">

                            <x-text-input
                                type="text"
                                name="search"
                                :value="$search"
                                placeholder="Cari NIM/NIDN, nama, atau email..."
                                class="w-full"
                            />

                            <select
                                name="role"
                                class="border-gray-300 rounded-md shadow-sm"
                            >
                                <option value="">
                                    Semua Role
                                </option>

                                <option value="USER" @selected($role === 'USER')>
                                    USER
                                </option>

                                <option value="STAFF" @selected($role === 'STAFF')>
                                    STAFF
                                </option>

                                <option value="ADMIN" @selected($role === 'ADMIN')>
                                    ADMIN
                                </option>
                            </select>

                            <x-primary-button>
                                Cari
                            </x-primary-button>

                            @if ($search || $role)
                                <a
                                    href="{{ route('admin.users.index') }}"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300"
                                >
                                    Reset
                                </a>
                            @endif

                        </div>
                    </form>

                    {{-- User Table --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200">

                            <thead>
                                <tr class="bg-gray-100">

                                    <th class="px-4 py-3 border text-left">
                                        NIM/NIDN
                                    </th>

                                    <th class="px-4 py-3 border text-left">
                                        Nama
                                    </th>

                                    <th class="px-4 py-3 border text-left">
                                        Email
                                    </th>

                                    <th class="px-4 py-3 border text-left">
                                        Role
                                    </th>

                                    <th class="px-4 py-3 border text-left">
                                        Status Email
                                    </th>

                                    <th class="px-4 py-3 border text-left">
                                        Aksi
                                    </th>

                                </tr>
                            </thead>

                            <tbody>

                                @forelse ($users as $user)

                                    <tr>

                                        <td class="px-4 py-3 border">
                                            {{ $user->nim_nidn }}
                                        </td>

                                        <td class="px-4 py-3 border">
                                            {{ $user->name }}
                                        </td>

                                        <td class="px-4 py-3 border">
                                            {{ $user->email }}
                                        </td>

                                        <td class="px-4 py-3 border">
                                            {{ $user->role }}
                                        </td>

                                        <td class="px-4 py-3 border">

                                            @if ($user->email_verified_at)

                                                <span class="text-green-600">
                                                    Terverifikasi
                                                </span>

                                            @else

                                                <span class="text-red-600">
                                                    Belum terverifikasi
                                                </span>

                                            @endif

                                        </td>

                                        <td class="px-4 py-3 border">

                                            @if ($user->role !== 'ADMIN')

                                                <form
                                                    method="POST"
                                                    action="{{ route('admin.users.update-role', $user) }}"
                                                    class="flex items-center gap-2"
                                                >

                                                    @csrf

                                                    @method('PATCH')

                                                    <select
                                                        name="role"
                                                        class="border-gray-300 rounded-md shadow-sm text-sm"
                                                    >

                                                        <option
                                                            value="USER"
                                                            @selected($user->role === 'USER')
                                                        >
                                                            USER
                                                        </option>

                                                        <option
                                                            value="STAFF"
                                                            @selected($user->role === 'STAFF')
                                                        >
                                                            STAFF
                                                        </option>

                                                    </select>

                                                    <x-primary-button>
                                                        Simpan
                                                    </x-primary-button>

                                                </form>

                                            @else

                                                <span class="text-gray-500 text-sm">
                                                    Admin
                                                </span>

                                            @endif

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="6"
                                            class="px-4 py-6 border text-center text-gray-500"
                                        >
                                            Belum ada user.
                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>