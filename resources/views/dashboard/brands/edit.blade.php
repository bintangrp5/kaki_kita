<x-layouts.app :title="__('Edit Brand')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Edit Brand</flux:heading>
        <flux:subheading size="lg" class="mb-6">Update your product brand information</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @if(session()->has('successMessage'))
        <flux:badge color="lime" class="mb-3 w-full">{{ session()->get('successMessage') }}</flux:badge>
    @elseif(session()->has('errorMessage'))
        <flux:badge color="red" class="mb-3 w-full">{{ session()->get('errorMessage') }}</flux:badge>
    @endif

    <form action="{{ route('brands.update', $brand->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <flux:input 
            label="Name" 
            name="name" 
            class="mb-3" 
            placeholder="Brand Name" 
            :value="old('name', $brand->name)" 
        />

       <flux:select label="Category" name="category_id" class="mb-3">
    <option value="">-- Pilih Kategori --</option>
    @foreach ($categories as $category)
        <option value="{{ $category->id }}"
            @selected(old('category_id', $brand->categories->first()->id ?? null) == $category->id)>
            {{ $category->name }}
        </option>
    @endforeach
</flux:select>




        <flux:input 
            label="Slug" 
            name="slug" 
            class="mb-3" 
            placeholder="auto-generated or custom slug" 
            :value="old('slug', $brand->slug)" 
        />

        <flux:textarea 
            label="Description" 
            name="description" 
            class="mb-3" 
            placeholder="Description about the brand"
        >{{ old('description', $brand->description) }}</flux:textarea>

        {{-- Tampilkan gambar jika ada --}}
        @if($brand->image)
            <div class="mb-3">
                <p class="text-sm text-muted">Current Image:</p>
                <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->name }}" style="height: 100px;">
            </div>
        @endif

        <flux:input 
            type="file" 
            label="Logo / Image (Leave empty if unchanged)" 
            name="image" 
            class="mb-3" 
        />

        <flux:input 
            type="number" 
            label="Order" 
            name="order" 
            class="mb-3" 
            placeholder="Display order (optional)" 
            :value="old('order', $brand->order)" 
        />

        <div class="mb-4">
            <label class="inline-flex items-center">
                <input 
                    type="checkbox" 
                    name="is_active" 
                    value="1" 
                    class="form-checkbox" 
                    {{ old('is_active', $brand->is_active) ? 'checked' : '' }}>
                <span class="ml-2">Active</span>
            </label>
        </div>

        <flux:separator />

        <div class="mt-4">
            <flux:button type="submit" variant="primary">Update</flux:button>
            <flux:link href="{{ route('brands.index') }}" variant="ghost" class="ml-3">Cancel</flux:link>
        </div>
    </form>
</x-layouts.app>
