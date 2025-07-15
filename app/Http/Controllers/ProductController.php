<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Categories;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $products = Product::when($q, function ($query) use ($q) {
            $query->where('name', 'like', "%$q%")
                ->orWhere('description', 'like', "%$q%");
        })->latest()->paginate(10);

        return view('dashboard.products.index', compact('products', 'q'));
    }

    public function create()
    {
        $categories = Categories::all();
        $brands = Brand::where('is_active', true)->orderBy('order')->get();
        return view('dashboard.products.create', compact('categories', 'brands'));
    }


    public function store(Request $request)
    {
        $messages = [
            'name.unique' => 'Nama produk sudah digunakan, silakan gunakan nama lain.',

        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:products,name',  // Tambah unique di sini
            'category_slug' => 'required|string|exists:product_categories,slug',
            'brand_id' => 'required|exists:brands,id',
            'slug' => 'required|string|max:255|unique:products,slug',
            'sku' => 'required|string|max:50|unique:products,sku',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $category = Categories::where('slug', $validated['category_slug'])->first();

        $imageUrl = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('images');
            $image->move($imagePath, $imageName);
            $imageUrl = 'images/' . $imageName;
        }

        Product::create([
            'name' => $validated['name'],
            'brand_id' => $validated['brand_id'],
            'slug' => Str::slug($validated['slug']),
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'sku' => $validated['sku'],
            'product_category_id' => $category->id,
            'image_url' => $imageUrl,
            'is_active' => ((int) $validated['stock'] > 0),
        ]);

        return redirect()->route('products.index')->with('successMessage', 'Data Berhasil Disimpan');
    }


    public function show(Product $product)
    {
        return view('dashboard.products.index', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Categories::all();
        $brands = Brand::where('is_active', true)->orderBy('order')->get();
        return view('dashboard.products.edit', compact('product', 'categories', 'brands'));
    }


    public function update(Request $request, Product $product)
    {
        $messages = [
            'name.unique' => 'Nama produk sudah digunakan, silakan gunakan nama lain.',

        ];
        $rules = [
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'category_slug' => 'required|string|exists:product_categories,slug',
            'brand_id' => 'required|exists:brands,id',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'sku' => 'required|string|max:50|unique:products,sku,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];

        $validated = $request->validate($rules);

        $category = Categories::where('slug', $validated['category_slug'])->first();

        $slug = Str::slug($validated['slug'] ?? $validated['name']);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('images');

            if ($product->image_url && file_exists(public_path($product->image_url))) {
                unlink(public_path($product->image_url));
            }

            $image->move($imagePath, $imageName);
            $imageUrl = 'images/' . $imageName;
        } else {
            $imageUrl = $product->image_url;
        }

        $product->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'sku' => $validated['sku'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'product_category_id' => $category->id,
            'brand_id' => $validated['brand_id'],
            'image_url' => $imageUrl,
            'is_active' => ((int) $validated['stock'] > 0),
        ]);

        return redirect()->route('products.index')->with('successMessage', 'Data Berhasil Diperbarui');
    }

     public function sync($id, Request $request)
      {
          $product = Product::findOrFail($id);
  
          $response = Http::post('https://api.phb-umkm.my.id/api/product/sync', [
              'client_id' => env('CLIENT_ID'),
              'client_secret' => env('CLIENT_SECRET'),
              'seller_product_id' => (string) $product->id,
              'name' => $product->name,
              'description' => $product->description,
              'price' => $product->price,
              'stock' => $product->stock,
              'sku' => $product->sku,
              'image_url' => $product->image_url,
              'weight' => $product->weight,
              'is_active' => $request->is_active == 1 ? false : true,
              'category_id' => (string) $product->category->hub_category_id,
          ]);
  
          if ($response->successful() && isset($response['product_id'])) {
              $product->hub_product_id = $request->is_active == 1 ? null : $response['product_id'];
              $product->save();
          }
  
          session()->flash('successMessage', 'Product Synced Successfully');
          return redirect()->back();
      }


    public function destroy(Product $product)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('successMessage', 'Data Berhasil Dihapus');
    }
    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->is_active = !$product->is_active;
        $product->save();

        return redirect()->back()->with('success', 'Status produk berhasil diperbarui.');
    }
}
