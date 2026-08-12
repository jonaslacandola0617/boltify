<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));
        $category = (string) $request->input('category');
        $stock = (string) $request->input('stock');

        $products = Product::query()
            ->with('category')
            ->when($search, fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->when($category, fn ($query) => $query->where('categoryId', $category))
            ->when($stock === 'low', fn ($query) => $query->where('stock', '<=', 5))
            ->when($stock === 'out', fn ($query) => $query->where('stock', 0))
            ->when($stock === 'available', fn ($query) => $query->where('stock', '>', 5))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $categories = Category::query()->orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories', 'search', 'category', 'stock'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateProduct($request, requireImages: false);

        $images = $this->storeImages($request, $validated['name']);

        Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'categoryId' => $validated['category'],
            'images' => json_encode($images),
        ]);

        return redirect()
            ->route('admin.product.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $product->load('category');

        $relatedProducts = Product::query()
            ->with('category')
            ->where('categoryId', $product->categoryId)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('product.show', compact('product', 'relatedProducts'));
    }

    public function edit(Product $product)
    {
        $product->load('category');
        $categories = Category::query()->orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $this->validateProduct($request, requireImages: false);

        $images = json_decode($product->images, true) ?: [];

        if ($request->hasFile('images')) {
            foreach ($images as $image) {
                Storage::disk('public')->delete($image);
            }

            $images = $this->storeImages($request, $validated['name']);
        }

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'categoryId' => $validated['category'],
            'images' => json_encode($images),
        ]);

        return redirect()
            ->route('admin.product.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->orders()->exists()) {
            return redirect()
                ->route('admin.product.index')
                ->with('error', 'Products attached to an order cannot be deleted. Set the stock to 0 instead.');
        }

        foreach (json_decode($product->images, true) ?: [] as $image) {
            Storage::disk('public')->delete($image);
        }

        $product->delete();

        return redirect()
            ->route('admin.product.index')
            ->with('success', 'Product deleted.');
    }

    private function validateProduct(Request $request, bool $requireImages): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category' => ['required', Rule::exists('categories', 'id')],
            'images' => [$requireImages ? 'required' : 'nullable', 'array', 'max:6'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
        ]);
    }

    private function storeImages(Request $request, string $productName): array
    {
        $paths = [];

        if (! $request->hasFile('images')) {
            return $paths;
        }

        $directory = str($productName)
            ->slug()
            ->append('-'.now()->format('YmdHis'))
            ->toString();

        foreach ($request->file('images') as $image) {
            $paths[] = $image->store($directory, 'public');
        }

        return $paths;
    }
}
