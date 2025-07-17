<x-layouts.app :title="__('Brands')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Add New Brand</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manage your product brands</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @if(session()->has('successMessage'))
    <flux:badge color="lime" class="mb-3 w-full">{{ session()->get('successMessage') }}</flux:badge>
    @elseif(session()->has('errorMessage'))
    <flux:badge color="red" class="mb-3 w-full">{{ session()->get('errorMessage') }}</flux:badge>
    @endif

    <form action="{{ route('brands.store') }}" method="post" enctype="multipart/form-data">
        @csrf

	<flux:input label="Name" name="name" class="mb-3" placeholder="Product Name"/>

	<flux:select label="Category" name="category_id" class="mb-3">
    		<option value="">-- Pilih Kategori --</option>
    		@foreach ($categories as $category)
        		<option value="{{ $category->id }}"
            			@selected(old('category_id', isset($brand) ? optional($brand->categories->first())->id : null) == $category->id)>
            		{{ $category->name }}
        	</option>
    	@endforeach
	</flux:select>


        <flux:input label="Slug" name="slug" class="mb-3" placeholder="auto-generated or custom slug" />
        <flux:textarea label="Description" name="description" class="mb-3" placeholder="Description about the brand" />
        <flux:input type="file" label="Logo / Image" name="image" class="mb-3" />

        <flux:input type="number" label="Order" name="order" class="mb-3" placeholder="Display order (optional)" />

        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_active" value="1" class="form-checkbox" checked>
                <span class="ml-2">Active</span>
            </label>
        </div>

        <flux:separator />

        <div class="mt-4">
            <flux:button type="submit" variant="primary">Save</flux:button>
            <flux:link href="{{ route('brands.index') }}" variant="ghost" class="ml-3">Back</flux:link>
        </div>
    </form>
</x-layouts.app>
