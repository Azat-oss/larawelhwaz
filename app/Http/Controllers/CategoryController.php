<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()->get();

        return view('category.index', compact('categories'));
    }

    public function create(): View
    {
        return view('category.create');
    }

    public function store(CategoryStoreRequest $categoryStoreRequest)
    {
        $newCategory = new Category();
        $newCategory->name = $categoryStoreRequest->name;
        $newCategory->is_active = $categoryStoreRequest->is_active;
        $newCategory->save();

        return redirect()->route('categories.edit', $newCategory->id);
    }

    public function edit(Category $category): View
    {
        $allCategories = Category::query()->get();

        return view('category.edit', compact('category', 'allCategories'));
    }

    public function update(
        CategoryUpdateRequest $categoryUpdateRequest,
        Category              $category
    )
    {
        $category->update($categoryUpdateRequest->validated());

        return redirect()->back()->with('success', 'Категория обновлена!');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('categories.index');
    }
}
