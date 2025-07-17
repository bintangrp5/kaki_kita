<x-layouts.app :title="__('Brands')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Brand</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manajemen merek produk</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <div class="flex justify-between items-center mb-4">
        <div>
            <form action="{{ route('brands.index') }}" method="get" class="w-full max-w-md">
                <flux:input icon="magnifying-glass" name="q" value="{{ request('q') }}" placeholder="Cari Brand" />
            </form>
        </div>
        <div>
            <flux:button icon="plus">
                <flux:link href="{{ route('brands.create') }}" variant="subtle">Tambah Brand Baru</flux:link>
            </flux:button>
        </div>
    </div>

    @if(session()->has('successMessage'))
    <flux:badge color="lime" class="mb-3 w-full">
        {{ session()->get('successMessage') }}
    </flux:badge>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                    <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Logo</th>
                    <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                    <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
                    <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Slug</th>
                    <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Deskripsi</th>
                    <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Order</th>
                    <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($brands as $key => $brand)
                <tr>
                    <td class="px-5 py-5 border-b text-sm">
                        {{ $key + 1 }}
                    </td>
                    <td class="px-5 py-5 border-b text-sm">
                        @if($brand->image)
                        <img src="{{ Storage::url($brand->image) }}" alt="{{ $brand->name }}" class="h-10 w-10 rounded object-cover">
                        @else
                        <div class="h-10 w-10 flex rounded object-cover">
                            <span class="text-gray-500 text-sm">N/A</span>
                        </div>
                        @endif
                    </td>
                    <td class="px-5 py-5 border-b text-sm">{{ $brand->name }}</td>
                    <td class="px-5 py-5 border-b text-sm">
                        {{ $brand->categories->first()->name ?? '-' }}
                    </td>


                    <td class="px-5 py-5 border-b text-sm">{{ $brand->slug }}</td>
                    <td class="px-5 py-5 border-b text-sm">{{ $brand->description ?? '-' }}</td>
                    <td class="px-5 py-5 border-b text-sm">
                        <span class="inline-block min-w-[80px] text-center px-3 py-1 rounded-full text-sm font-medium shadow-sm {{ $brand->is_active ? 'bg-green-200 text-green-900' : 'bg-gray-200 text-gray-800' }}">
                            {{ $brand->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-5 py-5 border-b text-sm">{{ $brand->order }}</td>
                    <td class="px-5 py-5 border-b text-sm">
                        <flux:dropdown>
                            <flux:button icon:trailing="chevron-down">Actions</flux:button>
                            <flux:menu>
                                <flux:menu.item icon="pencil" href="{{ route('brands.edit', $brand->id) }}">Edit</flux:menu.item>
                                <flux:menu.item icon="trash" variant="danger"
                                    onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this brand?')) document.getElementById('delete-form-{{ $brand->id }}').submit();">
                                    Delete
                                </flux:menu.item>
                                <form id="delete-form-{{ $brand->id }}" action="{{ route('brands.destroy', $brand->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </flux:menu>
                        </flux:dropdown>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-gray-500 py-4">Tidak ada merek yang ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>


        <div class="mt-3">
            {{ $brands->links() }} {{-- ✅ Aman sekarang --}}
        </div>

    </div>
</x-layouts.app>