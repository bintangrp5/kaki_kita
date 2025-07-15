<x-layout>
    <x-slot name="title">Brands</x-slot>

    <div class="container py-3">

        {{-- Filter Kategori --}}
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <h3 class="mb-0 me-3" style="font-size: 1.5rem;">Brands</h3>

            <div class="d-flex align-items-center flex-wrap gap-3">
                <div id="category-filters" class="fw-bold d-flex gap-3">
                    <span class="filter-category text-primary active" data-category="all" style="cursor:pointer;">
                        Semua
                    </span>
                    @foreach($categories as $category)
                        <span class="filter-category text-dark" data-category="{{ $category->slug }}" style="cursor:pointer;">
                            {{ $category->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- List Produk Brand --}}
        <div class="row" id="product-list">
            @forelse($products as $product)
                @php
                    $brandSlug = $product->brand->slug ?? '';
                    $categorySlug = $product->category->slug ?? '';
                @endphp
                <div class="col-md-3 mb-4 product-item"
                     data-brand="{{ $brandSlug }}"
                     data-category="{{ $categorySlug }}">
                    <div class="card product-card h-100 shadow-sm">
                        <img src="{{ $product->image_url ?: 'https://via.placeholder.com/350x200?text=No+Image' }}"
                             class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-truncate">{{ $product->description }}</p>
                            <div class="mt-auto">
                                <span class="fw-bold text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <a href="{{ url('/product/' . $product->slug) }}" class="btn btn-outline-primary btn-sm float-end">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col">
                    <div class="alert alert-info">Belum ada produk tersedia.</div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center w-100 mt-4">
            {{ $products->links('vendor.pagination.simple-bootstrap-5') }}
        </div>
    </div>

    {{-- JavaScript Filter --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterButtons = document.querySelectorAll('.filter-category');
            const productItems = document.querySelectorAll('.product-item');

            filterButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    const selectedCategory = this.getAttribute('data-category');

                    // Ubah class aktif
                    filterButtons.forEach(b => {
                        b.classList.remove('text-primary', 'active');
                        b.classList.add('text-dark');
                    });
                    this.classList.remove('text-dark');
                    this.classList.add('text-primary', 'active');

                    // Filter produk berdasarkan kategori
                    productItems.forEach(item => {
                        const itemCategory = item.getAttribute('data-category');
                        if (selectedCategory === 'all' || itemCategory === selectedCategory) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
</x-layout>
