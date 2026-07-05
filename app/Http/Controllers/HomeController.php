<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use function PHPSTORM_META\map;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $column = null;
        $direction = null;
        $query = Product::query();
        $categories = Category::query()->orderBy('name')->get();

        list($column, $direction) = explode('-', $request->input('sort', 'created_at-desc'));

        if ($request->input('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%')
                ->orWhere('description', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->input('price_from')) {
            $query->where('price', '>=', $request->input('price_from'));
        }
        if ($request->input('price_to')) {
            $query->where('price', '<=', $request->input('price_to'));
        }
        if ($request->input('category')) {
            $query->where('category_id', $request->input('category'));
        }

        return view('home', [
            'categories' => $categories,
            'products' => $query
                ->orderBy($column, $direction)
                ->paginate(12)
                ->withQueryString(),
        ]);
    }
}
