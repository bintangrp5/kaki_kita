<x-layout>
 <x-slot name="title"> {{$category->name}}</x-slot>
<div class="container py-5">
    <h2 class="mb-4">{{ $category->name }}</h2>

    @if($products->isEmpty())
        <p>Tidak ada produk dalam kategori ini.</p>
    @else
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($products as $product)
                <div class="col">
                    <div class="card h-100">
                        @if($product->image_url)
				 <img src="{{ $product->image_url ? Storage::url($product->image_url) : 'https://via.placeholder.com/350x200?text=No+Image' }}"
                        alt="{{ $product->name }}"
                        class="card-img-top object-fit-contain" style="height: 200px;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ \Str::limit($product->description, 100) }}</p>
                            <a href="{{ route('product.show', $product->slug) }}" class="btn btn-outline-primary btn-sm">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
</x-layout>
