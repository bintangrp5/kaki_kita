<x-layout>
    <x-slot name="title">KakiKita</x-slot>
    <div class="container py-3">
        <div class="container" style="padding-top: 1rem; padding-bottom: 1rem;">
            <div class="banner-container" style="position: relative; overflow: hidden; height: 350px;"
                onmouseover="pauseAutoplay(); showPagination()" onmouseout="resumeAutoplay(); hidePagination()">

                <!-- Slide 1 -->
                <div class="banner-slide" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        opacity: 1; z-index: 2; transition: opacity 1s ease-in-out;">
                    <img src="{{ asset('images/banner kakikita (1).jpeg') }}" alt="Penawaran Spesial 1"
                        style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                </div>

                <!-- Slide 2 -->
                <div class="banner-slide" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        opacity: 0; z-index: 1; transition: opacity 1s ease-in-out;">
                    <img src="{{ asset('images/banner kakikita (2).jpeg') }}" alt="Penawaran Spesial 2"
                        style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                </div>

                <!-- Slide 3 -->
                <div class="banner-slide" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        opacity: 0; z-index: 1; transition: opacity 1s ease-in-out;">
                    <img src="{{ asset('images/banner kakikita (3).jpeg') }}" alt="Penawaran Spesial 3"
                        style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                </div>

                <!-- Pagination -->
                <div id="pagination" style="position: absolute; bottom: 15px; left: 50%; transform: translateX(-50%);
        display: none; z-index: 3; display: flex; gap: 10px;">
                    <button onclick="showSlide(0); resetAutoplay()" style="height: 12px; width: 12px; background-color: white;
          border-radius: 50%; cursor: pointer; opacity: 0.6; border: none; padding: 0;" class="dot"></button>
                    <button onclick="showSlide(1); resetAutoplay()" style="height: 12px; width: 12px; background-color: white;
          border-radius: 50%; cursor: pointer; opacity: 0.6; border: none; padding: 0;" class="dot"></button>
                    <button onclick="showSlide(2); resetAutoplay()" style="height: 12px; width: 12px; background-color: white;
          border-radius: 50%; cursor: pointer; opacity: 0.6; border: none; padding: 0;" class="dot"></button>
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION: FITUR ATAS --}}
    <div class="container py-4">
        <div class="row text-center g-3">
            <div class="col-md-3">
                <div class="p-3 text-white rounded shadow-sm" style="background: linear-gradient(90deg, #0053C7 0%, #0065F8 100%)">
                    <div class="mb-2">
                        <i class="bi bi-truck" style="font-size: 1.5rem;"></i>
                    </div>
                    <h6 class="mb-1 fw-bold">PENGIRIMAN CEPAT BANGET</h6>
                    <p class="mb-0 small">Kurir pengiriman yang handal</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 text-white rounded shadow-sm" style="background: linear-gradient(90deg, #0053C7 0%, #0065F8 100%)">
                    <div class="mb-2">
                        <i class="bi bi-check2-circle" style="font-size: 1.5rem;"></i>
                    </div>
                    <h6 class="mb-1 fw-bold">KUALITAS TERJAMIN</h6>
                    <p class="mb-0 small">3 Bulan garansi produk</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 text-white rounded shadow-sm" style="background: linear-gradient(90deg, #0053C7 0%, #0065F8 100%)">
                    <div class="mb-2">
                        <i class="bi bi-cash" style="font-size: 1.5rem;"></i>
                    </div>
                    <h6 class="mb-1 fw-bold">PEMBAYARAN MUDAH</h6>
                    <p class="mb-0 small">Bisa Cash On Delivery</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 text-white rounded shadow-sm" style="background: linear-gradient(90deg, #0053C7 0%, #0065F8 100%)">
                    <div class="mb-2">
                        <i class="bi bi-person-smile" style="font-size: 1.5rem;"></i>
                    </div>
                    <h6 class="mb-1 fw-bold">ADMIN BERSAHABAT</h6>
                    <p class="mb-0 small">Admin yang ramah dan edukatif</p>
                </div>
            </div>
        </div>
    </div>


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

                <!-- {{-- Tombol Lihat Semua Kategori --}}
            <a href="{{ URL::to('/categories') }}" class="btn btn-outline-primary btn-sm ms-3">
                Lihat Semua Kategori
            </a> -->
            </div>
        </div>

        {{-- Konten Brand --}}
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3" id="brand-display">
            @forelse($brands as $brand)
            @php
            $categorySlugs = $brand->categories->pluck('slug')->implode(' ');
            @endphp
            <div class="col brand-item" data-category="{{ $categorySlugs }}" data-brand-slug="{{ $brand->slug }}">

                <div class="card text-center h-100 py-3 border-0 shadow-sm">
                    <div class="mx-auto mb-2"
                        style="width:64px;height:64px;display:flex;align-items:center;justify-content:center;background:#f8f9fa;border-radius:50%;">
                        <img src="{{ asset('storage/' . ($brand->image ?? 'images/default.png')) }}" alt="{{ $brand->name }}"
                            style="width:36px;height:36px;object-fit:contain;">
                    </div>
                    <div class="card-body p-2 d-flex flex-column">
                        <h6 class="card-title mb-1 text-dark">{{ $brand->name }}</h6>
                        <p class="card-text text-muted small text-truncate">{{ $brand->description }}</p>
                        <a href="#" class="btn btn-primary btn-lihat-brand">Lihat Brand</a>

                    </div>
                </div>
            </div>
            @empty
            <p class="text-center w-100">Tidak ada brand tersedia</p>
            @endforelse
        </div>
    </div>



    {{-- Banner Promosi --}}
    <div class="container py-3">
        <div class="row mt-4">
            <div class="col-md-6 mb-3">
                <a href="#" class="d-block w-100 h-100">
                    <img src="{{ asset('images/banner kakikita (7).png') }}" alt="Penawaran Spesial Nike Forum Low"
                        class="img-fluid rounded shadow-sm w-100 h-100 object-fit-cover">
                </a>
            </div>
            <div class="col-md-6 mb-3">
                <a href="#" class="d-block w-100 h-100">
                    <img src="{{ asset('images/home-banner1.png') }}" alt="Koleksi Terbaru Sepatu Converse"
                        class="img-fluid rounded shadow-sm w-100 h-100 object-fit-cover">
                </a>
            </div>
        </div>
    </div>

    <div class="container py-4">
        <!-- Produk Terbaru -->
        <h4 class="mb-4">Produk Terbaru</h4>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @forelse($newestProducts as $product)
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    <img src="{{ $product->image_url ? Storage::url($product->image_url) : 'https://via.placeholder.com/350x200?text=No+Image' }}"
                        alt="{{ $product->name }}"
                        class="card-img-top object-fit-contain" style="height: 200px;">

                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title mb-2 text-truncate">{{ $product->name }}</h6>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="text-primary fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <a href="{{ route('product.show', $product->slug) }}" class="btn btn-outline-primary btn-sm">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <p>Tidak ada produk terbaru</p>
            @endforelse
        </div>
    </div>


    <!-- Produk Terlaris -->
    <!-- <h4 class="mt-5">Produk Terlaris</h4>
        <div class="row">
            @forelse($bestSellerProducts as $product)
            <div class="col-md-3 mb-3">
                <div class="card h-100">
                    <img src="{{ $product->image_url ?? 'https://via.placeholder.com/350x200?text=No+Image' }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <span class="text-primary fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            @empty
            <p>Tidak ada produk terlaris</p>
            @endforelse
        </div> -->
    </div>

    {{-- Banner Promosi 2--}}
    <div class="container py-3">
        <div class="row mt-4">
            <div class="col-12 mb-3">
                <a href="#" class="d-block w-100 h-100">
                    <img src="{{ asset('images/banner kakikita (5).jpeg') }}" alt="Penawaran Spesial Nike Forum Low"
                        class="img-fluid rounded shadow-sm w-100 object-fit-cover" style="width:100%;height:auto;">
                </a>
            </div>
        </div>
    </div>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0" style="font-size: 1.5rem;">Produk Kami</h3>
            <a href="{{ url('/products') }}" class="btn btn-outline-primary btn-sm">Lihat Semua Produk</a>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @forelse($products as $product)
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    <img src="{{ $product->image_url ? Storage::url($product->image_url) : 'https://via.placeholder.com/350x200?text=No+Image' }}"
                        alt="{{ $product->name }}"
                        class="card-img-top object-fit-contain" style="height: 200px;">

                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title text-truncate mb-2">{{ $product->name }}</h6>
                        <p class="card-text text-muted small text-truncate">{{ $product->description }}</p>

                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <a href="{{ route('product.show', $product->slug) }}"
                                class="btn btn-outline-primary btn-sm">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">Belum ada produk pada kategori ini.</div>
            </div>
            @endforelse
        </div>

        @if ($products->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links('vendor.pagination.bootstrap-5') }}
        </div>
        @endif
    </div>


    {{-- JavaScript untuk filter kategori --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-category');
            const brandItems = document.querySelectorAll('.brand-item');

            // ✅ SET DEFAULT LINK SAAT FILTER = "Semua"
            brandItems.forEach(item => {
                const lihatBrandBtn = item.querySelector('.btn-lihat-brand');
                const brandSlug = item.getAttribute('data-brand-slug');
                if (lihatBrandBtn && brandSlug) {
                    lihatBrandBtn.setAttribute('href', '/categories_brand?brand=' + brandSlug);
                }
            });

            // ⬇️ Ini tetap seperti sebelumnya
            filterButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const category = this.getAttribute('data-category');

                    // Set active class
                    filterButtons.forEach(b => {
                        b.classList.remove('text-primary', 'active');
                        b.classList.add('text-dark');
                    });
                    this.classList.remove('text-dark');
                    this.classList.add('text-primary', 'active');

                    // Update brand tampil + tombol
                    brandItems.forEach(item => {
                        const itemCategory = item.getAttribute('data-category');
                        const lihatBrandBtn = item.querySelector('.btn-lihat-brand');
                        const brandSlug = item.getAttribute('data-brand-slug');

                        if (category === 'all' || itemCategory.includes(category)) {
                            item.style.display = 'block';

                            if (lihatBrandBtn) {
                                if (category === 'all') {
                                    lihatBrandBtn.setAttribute('href', '/categories_brand?brand=' + brandSlug);
                                } else {
                                    lihatBrandBtn.setAttribute('href', '/category/' + category + '?brand=' + brandSlug);
                                }
                            }
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        });



        // JavaScript untuk banner slideshow
        let currentSlide = 0;
        let autoplayInterval;

        function showSlide(index) {
            const slides = document.querySelectorAll('.banner-slide');
            const dots = document.querySelectorAll('#pagination .dot');

            slides.forEach((slide, i) => {
                slide.style.zIndex = (i === index) ? '2' : '1';
                slide.style.opacity = (i === index) ? '1' : '0';
            });

            dots.forEach((dot, i) => {
                dot.style.opacity = (i === index) ? '1' : '0.6';
            });

            currentSlide = index;
        }

        function nextSlide() {
            const slides = document.querySelectorAll('.banner-slide');
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        function startAutoplay() {
            autoplayInterval = setInterval(nextSlide, 7000);
        }

        function pauseAutoplay() {
            clearInterval(autoplayInterval);
        }

        function resumeAutoplay() {
            startAutoplay();
        }

        function resetAutoplay() {
            pauseAutoplay();
            startAutoplay();
        }

        function showPagination() {
            document.getElementById('pagination').style.display = 'flex';
        }

        function hidePagination() {
            document.getElementById('pagination').style.display = 'none';
        }

        window.addEventListener('DOMContentLoaded', () => {
            showSlide(0);
            startAutoplay();
        });
    </script>
</x-layout>