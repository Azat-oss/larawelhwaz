<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private const PER_PAGE = 12;

    public function index(Request $request)
    {
        $sort = $request->get('sort', 'price');
        $arrayOrderBy = explode('_', $sort);
        $direction = last($arrayOrderBy) == 'asc' ? 'desc' : 'asc';
        if (count($arrayOrderBy) > 1) {
            unset($arrayOrderBy[count($arrayOrderBy) - 1]);
        }
        $columnName = implode('_', $arrayOrderBy);

        $products = Product::Filter($request)
            ->orderBy($columnName, $direction)
            ->paginate(self::PER_PAGE);

        $categories = Category::OnlySubCategories()->get();

        return view('products.index', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->whereNotNull('parent_id')->get();
        $tags = Tag::Active()->get();

        return view('products.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0|max:999999.99',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Обработка изображения
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->store('products', 'public');
            $validated['image'] = 'storage/' . $imageName;
        }

        DB::beginTransaction();
        try {
            $product = Product::create($validated);
            $product->tags()->attach($request->tags);

            DB::commit();
            return redirect()->route('products.index')
                ->with('success', 'Продукт успешно создан!');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::critical($exception->getMessage());

            if (File::exists($validated['image'])) {
                File::delete($validated['image']);
            }
            return redirect()->back();
        }
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        $tags = Tag::Active()->get();
        return view('products.edit',
            compact('product', 'categories', 'tags'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0|max:999999.99',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Удаляем старое изображение
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            $image = $request->file('image');
            $imageName = Str::slug($request->name) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/products', $imageName);
            $validated['image'] = 'storage/products/' . $imageName;
        }

        DB::beginTransaction();
        try {
            $product->update($validated);
            $product->tags()->sync($request->tags);
            DB::commit();
        } catch (\Exception $exception) {
            Log::critical($exception->getMessage());
            DB::rollBack();
            return redirect()->back();
        }

        return redirect()->back()
            ->with('success', 'Продукт успешно обновлен!');
    }

    public function destroy(Product $product)
    {
        // Удаляем изображение
//        if ($product->image && file_exists(public_path($product->image))) {
//            unlink(public_path($product->image));
//        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Продукт успешно удален!');
    }
}
