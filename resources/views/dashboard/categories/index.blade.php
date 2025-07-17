<x-layouts.app :title="('Categories')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Kategori Produk</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manajemen data kategori produk</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    {{-- Notifikasi --}}
    @if(session()->has('successMessage'))
    <flux:badge color="lime" class="mb-3 w-full">{{ session('successMessage') }}</flux:badge>
    @elseif(session()->has('errorMessage'))
    <flux:badge color="red" class="mb-3 w-full">{{ session('errorMessage') }}</flux:badge>
    @endif

    {{-- Search & Add New Category --}}
    <div class="flex justify-between items-center mb-4">
        <form action="{{ route('categories.index') }}" method="get" class="w-full max-w-md">
            <flux:input icon="magnifying-glass" name="q" value="{{ request('q') }}" placeholder="Cari Kategori" />
        </form>
        <flux:link href="{{ route('categories.create') }}" class="ml-4">
            <flux:button icon="plus" variant="subtle">
                Tambah Kategori Baru
            </flux:button>
        </flux:link>
    </div>

    {{-- Tabel Kategori --}}
    <div class="overflow-x-auto">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    @foreach(['ID', 'Gambar', 'Nama', 'Slug', 'Deskripsi', 'On/Off', 'Aksi'] as $heading)
                    <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">
                        {{ $heading }}
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $key => $category)
                <tr>
                    {{-- ID --}}
                    <td class="px-5 py-5 border-b text-sm">{{ $category->id }}</td>

                    {{-- Gambar --}}
                    <td class="px-5 py-5 border-b text-sm">
                        @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                            class="h-10 w-10 rounded object-cover">
                        @else
                        <span class="text-gray-400 text-sm">Tidak ada gambar</span>
                        @endif
                    </td>

                    {{-- Name --}}
                    <td class="px-5 py-5 border-b text-sm">{{ $category->name }}</td>

                    {{-- Slug --}}
                    <td class="px-5 py-5 border-b text-sm">{{ $category->slug }}</td>

                    {{-- Description --}}
                    <td class="px-5 py-5 border-b text-sm">{{ $category->description ?? '-' }}</td>

                    <td>
                        <form id="sync-category-{{ $category->id }}" action="{{ route('category.sync', $category->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="is_active" value="@if($category->hub_category_id) 1 @else 0 @endif">
                            @if($category->hub_category_id)
                            <flux:switch checked onchange="document.getElementById('sync-category-{{ $category->id }}').submit()" />
                            @else
                            <flux:switch onchange="document.getElementById('sync-category-{{ $category->id }}').submit()" />
                            @endif
                        </form>
                    </td>



                    {{-- Actions --}}
                    <td class="px-5 py-5 border-b text-sm">
                        <flux:dropdown>
                            <flux:button icon:trailing="chevron-down">Actions</flux:button>
                            <flux:menu>
                                <flux:menu.item icon="pencil" href="{{ route('categories.edit', $category->id) }}">
                                    Edit
                                </flux:menu.item>
                                <flux:menu.item
                                    icon="trash"
                                    variant="danger"
                                    onclick="event.preventDefault(); if(confirm('Yakin ingin menghapus kategori ini?')) document.getElementById('delete-form-{{ $category->id }}').submit();">
                                    Delete
                                </flux:menu.item>
                                <form id="delete-form-{{ $category->id }}" action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </flux:menu>
                        </flux:dropdown>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $categories->links() }}
        </div>
    </div>
</x-layouts.app>