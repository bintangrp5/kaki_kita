<x-layout>
    <x-slot name="title"> Brands by Category</x-slot>

    <div class="container py-3">
        {{-- Header dan Filter --}}
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <h3 class="mb-0 me-3" style="font-size: 1.5rem;">Brands</h3>

            <div class="d-flex align-items-center flex-wrap gap-3">
                {{-- Filter --}}
                <div id="category-filters" class="fw-bold d-flex gap-3">
                    {{-- Tombol Semua --}}
                    <span class="filter-category text-primary active" data-category="all" style="cursor:pointer;">
                        Semua
                    </span>
                    {{-- Tombol per kategori --}}
                    @foreach($categories as $category)
                    <span class="filter-category text-dark" data-category="{{ $category->slug }}" style="cursor:pointer;">
                        {{ $category->name }}
                    </span>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Konten Brand --}}
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3" id="brand-display">
            @forelse($brands as $brand)
                @php
                    $categorySlugs = $brand->categories->pluck('slug')->implode(' ');
                @endphp
                <div class="col brand-item" data-category="{{ $categorySlugs }}">
                    <div class="card text-center h-100 py-3 border-0 shadow-sm">
                        <div class="mx-auto mb-2"
                            style="width:64px;height:64px;display:flex;align-items:center;justify-content:center;background:#f8f9fa;border-radius:50%;">
                            <img src="{{ asset('storage/' . ($brand->image ?? 'images/default.png')) }}"
                                alt="{{ $brand->name }}"
                                style="width:36px;height:36px;object-fit:contain;">
                        </div>
                        <div class="card-body p-2 d-flex flex-column">
                            <h6 class="card-title mb-1 text-dark">{{ $brand->name }}</h6>
                            <p class="card-text text-muted small text-truncate">{{ $brand->description }}</p>

                            {{-- ✅ Tombol diarahkan ke halaman brand --}}
                            <a href="{{ url('/brand/' . $brand->slug) }}"
                                class="btn btn-sm btn-outline-primary mt-auto">Lihat Brand</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center w-100">Tidak ada brand tersedia</p>
            @endforelse
        </div>
    </div>
</x-layout>
