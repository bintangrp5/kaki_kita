<x-layouts.app :title="'Dashboard'">
    <!-- BOX STATISTIK -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Total Products -->
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold">Total ProductsNYA iniiiiiii</h3>
            <p class="text-2xl">{{ $totalProducts }}</p>
            <span class="text-sm text-gray-500">Active Products: {{ $activeProducts }}</span>
        </div>

        <!-- Total Categories -->
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold">Total Categories</h3>
            <p class="text-2xl">{{ $totalCategories }}</p>
            <span class="text-sm text-gray-500">With Products: {{ $categoriesWithProducts }}</span>
        </div>

        <!-- Total Brands -->
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold">Total Brands</h3>
            <p class="text-2xl">{{ $totalBrands }}</p>
            <span class="text-sm text-gray-500">With Products: {{ $brandsWithProducts }}</span>
        </div>

        <!-- Total Orders -->
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold">Total Orders</h3>
            <p class="text-2xl">{{ $totalOrders }}</p>
            <span class="text-sm text-gray-500">Pending: {{ $pendingOrders }} | Processing: {{ $processingOrders }}</span>
        </div>
    </div>

    <!-- RECENT ORDERS DAN PRODUCTS -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <div class="bg-white p-6 rounded-xl shadow">
            <div class="flex justify-between items-center mb-4">
                <div class="text-gray-900 font-semibold text-lg">Recent Orders</div>
                <a href="{{ route('detail_order.index') }}" class="text-red-600 text-sm">View All</a>
            </div>
            <div class="space-y-3">
                @forelse ($recentOrders as $order)
                <div>
                    <div class="text-gray-900 font-semibold">
                        #{{ $order->id }} - {{ $order->customer_name }}
                    </div>
                    <div class="text-gray-600 text-sm">
                        {{ $order->created_at->diffForHumans() }}
                    </div>
                    <div class="text-green-600 text-sm font-semibold">
                        {{ ucfirst($order->status) }}
                    </div>
                </div>
                @empty
                <div class="text-gray-600">No recent orders.</div>
                @endforelse
            </div>
        </div>

        <!-- Recent Products -->
        <div class="bg-white p-6 rounded-xl shadow">
            <div class="flex justify-between items-center mb-4">
                <div class="text-gray-900 font-semibold text-lg">Recent Products</div>
                <a href="{{ route('products.index') }}" class="text-red-600 text-sm">View All</a>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach ($recentProducts as $product)
                <div class="flex items-center py-3">
                    <img src="{{ Storage::url($product->image_url) }}" alt="{{ $product->name }}"
                        class="h-10 w-10 rounded object-cover">
                    <div class="flex-1 ml-4">
                        <div class="text-gray-900 font-medium">{{ $product->name }}</div>
                        <div class="text-gray-600 text-sm">{{ $product->category->name ?? '-' }}</div>
                    </div>
                    <div class="text-right text-sm">
                        <div class="text-gray-900 font-semibold">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                        <div class="text-gray-600">Stock: {{ $product->stock }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</x-layouts.app>