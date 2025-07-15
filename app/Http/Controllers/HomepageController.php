<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Product;
use App\Models\Brand;
use \Binafy\LaravelCart\Models\Cart;

class HomepageController extends Controller
{
    private $themeFolder;
    public function __construct()
    {
        $this->themeFolder = 'web';
    }
    public function index()
    {
        $categories = Categories::latest()->take(4)->get();
        $products = Product::paginate(20);
        $brands = Brand::with('categories')->get(); // atau hanya Brand::all()

        // Tambahan: ambil 5 produk terbaru
        $newestProducts = Product::orderBy('created_at', 'desc')->take(5)->get();

        // Tambahan: ambil 5 produk terlaris (pastikan kolom `sold` ada, atau sesuaikan)
        $bestSellerProducts = Product::orderBy('sold', 'desc')->take(5)->get();

        return view($this->themeFolder . '.homepage', [
            'categories' => $categories,
            'products' => $products,
            'newestProducts' => $newestProducts,
            'bestSellerProducts' => $bestSellerProducts,
            'brands' => $brands, // ✅ tambahkan ini
            'title' => 'Homepage'
        ]);
    }


    public function products(Request $request)
    {
        $title = "Products";
        $query = Product::query();
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $products = $query->paginate(20);
        return view($this->themeFolder . '.products', [
            'title' => $title,
            'products' => $products,
        ]);
    }
    public function product($slug)
    {
        $product = Product::whereSlug($slug)->first();
        if (!$product) {
            return abort(404);
        }
        $relatedProducts = Product::where('product_category_id', $product->product_category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();
        return view($this->themeFolder . '.product', [
            'slug' => $slug,
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
    public function categories_brand()
    {
        
        $categories = Categories::latest()->paginate(20);
        $brands = Brand::with('categories')->latest()->get();
        return view($this->themeFolder . '.categories_brand', [
            'title' => 'Categories',
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }
    public function category($slug, Request $request)
{
    $category = Categories::whereSlug($slug)->first();

    if (!$category) {
        return abort(404);
    }

    $query = Product::where('product_category_id', $category->id);

    // Jika ada parameter brand di URL, filter juga berdasarkan brand
    if ($request->has('brand')) {
        $brandSlug = $request->query('brand');
        $brand = Brand::where('slug', $brandSlug)->first();

        if ($brand) {
            $query->where('brand_id', $brand->id);
        }
    }

    $products = $query->paginate(20);

    return view($this->themeFolder . '.category_by_slug', [
        'slug' => $slug,
        'category' => $category,
        'products' => $products,
    ]);
}

    public function checkout()
    {
        return view($this->themeFolder.'.checkout',[
            'title'=>'Checkout'
        ]);
    }
}
