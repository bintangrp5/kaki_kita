<x-layout>
    <x-slot name="title">Pesanan Saya</x-slot>

    <div class="container py-5">
        <h1 class="mb-4 fw-bold fs-2">Pesanan Saya</h1>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                            <td>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td>
                                @if ($order->status === 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif ($order->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-pink text-white">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .btn-pink {
            background-color: #e83e8c;
            border: none;
        }

        .btn-pink:hover {
            background-color: #d63384;
        }
    </style>
</x-layout>
