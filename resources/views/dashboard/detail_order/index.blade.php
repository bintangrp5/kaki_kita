<x-layouts.app :title="__('Orders Detail')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Manajemen pesanan</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manajemen pesanan pelanggan</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @if(session('success'))
    <flux:badge color="lime" class="mb-4 w-full">
        {{ session('success') }}
    </flux:badge>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Order ID</th>
                    <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                    <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                    <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                    <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    <!-- <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th> -->
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                <tr>
                    <td class="px-5 py-5 border-b text-sm">#{{ $order->id }}</td>
                    <td class="px-5 py-5 border-b text-sm">
                        <p class="font-medium">{{ $order->customer->name ?? '-' }}</p>
                        <p class="text-xs text-gray-500">{{ $order->customer->email ?? '-' }}</p>
                    </td>
                    <td class="px-5 py-5 border-b text-sm">
                        {{ $order->order_date ?? $order->created_at->format('d M Y') }}
                    </td>
                    <td class="px-5 py-5 border-b text-sm">
                        <strong>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                    </td>
                    <td class="px-5 py-5 border-b text-sm">
                        <form action="{{ route('detail_order.update', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-select text-sm" onchange="this.form.submit()">
                                @foreach(['pending', 'processing', 'completed', 'cancelled'] as $status)
                                <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                    <td class="px-5 py-5 border-b text-sm">
                        <flux:dropdown>
                            <!-- <flux:button icon:trailing="chevron-down" variant="subtle">Actions</flux:button>
                            <flux:menu>

                            </flux:menu> -->
                        </flux:dropdown>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-500 py-6">Tidak ada pesanan ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.app>