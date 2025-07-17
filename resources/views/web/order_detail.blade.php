<x-layout>
    <x-slot name="title">Detail Pesanan</x-slot>
    <div class="container my-5">
        <h3 class="mb-4">Detail Pesanan #{{ $order->id }}</h3>

        <div class="card mb-4">
            <div class="card-header">
                <strong>Informasi Pesanan</strong>
            </div>
            <div class="card-body">
                <p><strong>Tanggal Pesan:</strong> {{ $order->created_at->format('d M Y') }}</p>
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                <p><strong>Total:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <strong>Daftar Produk</strong>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->details as $detail)
                        <tr>
                            <td>{{ $detail->product->name ?? '-' }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>Rp {{ number_format($detail->unit_price, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>