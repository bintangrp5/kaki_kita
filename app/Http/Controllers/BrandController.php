<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $brands = Brand::when($q, function ($query) use ($q) {
            $query->where('name', 'like', "%$q%")
                ->orWhere('description', 'like', "%$q%");
        })->orderBy('name')->paginate(10);

        return view('dashboard.brands.index', compact('brands', 'q'));
    }

    public function create()
    {
        $categories = Categories::all(); // atau ProductCategory::all()
    return view('dashboard.brands.create', compact('categories'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|unique:brands,name',
        'category_id' => 'required|exists:product_categories,id', // ✅ BENAR
        'description' => 'nullable',
        'image' => 'nullable|image|max:2048',
        'is_active' => 'boolean',
        'order' => 'integer',
    ]);

    $validated['slug'] = Str::slug($request->name);

    if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/brands', 'public');
            $validated['image'] = $imagePath;
        }

    $brand = Brand::create($validated);

    // Attach kategori ke brand (many-to-many)
    $brand->categories()->attach($request->category_id);

    return redirect()->route('brands.index')->with('success', 'Brand berhasil ditambahkan.');
}


    public function edit(Brand $brand)
    {
        $categories = Categories::all(); 


        return view('dashboard.brands.edit', compact('brand','categories'));
    }

    public function update(Request $request, Brand $brand)
{
    $validated = $request->validate([
        'name' => 'required|unique:brands,name,' . $brand->id,
        'category_id' => 'required|exists:product_categories,id', // ✅ BENAR
        'description' => 'nullable',
        'image' => 'nullable|image|max:2048',
        'is_active' => 'boolean',
        'order' => 'integer',
    ]);

    $validated['slug'] = Str::slug($request->name);

    // Upload image jika ada
    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('brands', 'public');
        $imagePath = $request->file('image')->store('products', 'public');
    }
    


    // Update kolom di tabel brands
    $brand->update($validated);

    // Sinkronkan kategori ke tabel pivot
    $brand->categories()->sync([$request->category_id]);

    return redirect()->route('brands.index')->with('success', 'Brand berhasil diperbarui.');
}


    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('brands.index')->with('success', 'Brand berhasil dihapus.');
    }
}
