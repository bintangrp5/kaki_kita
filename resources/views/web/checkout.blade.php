<x-layout>
    <x-slot name="title">Checkout</x-slot>

    <div class="container py-5">
        <h1 class="mb-4 fs-2 fw-bold">Checkout</h1>

        <div class="row g-4">
            <!-- Informasi Pengiriman -->
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="fs-4 fw-semibold mb-3">Informasi Pengiriman</h2>
                        @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
                        <form action="{{ route('checkout.process') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" required class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" required class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="text" name="phone" required class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea name="address" rows="3" required class="form-control"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Catatan (opsional)</label>
                                <textarea name="note" rows="2" class="form-control"></textarea>
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="btn btn-primary">Pesan Sekarang</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="fs-5 fw-semibold mb-3">Ringkasan Pesanan</h2>

                        @php $total = 0; @endphp

                        @if($cart && $cart->items && count($cart->items))
                        @php $total = 0; @endphp
                        @foreach($cart->items as $item)
                        @php
                        $subtotal = $item->itemable->price * $item->quantity;
                        $total += $subtotal;
                        @endphp
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ $item->itemable->name }} ({{ $item->quantity }}x)</span>
                            <span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total</span>
                            <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        @else
                        <p>Keranjang belanja kosong.</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>