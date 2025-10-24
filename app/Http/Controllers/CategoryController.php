<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return Inertia::render('categories/index', [
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        return Inertia::render('categories/create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);
        $category = Category::create($validated);
        return to_route('categories.index');
    }

    public function edit(Category $category)
    {
        // dd($request->all());
        return Inertia::render('categories/edit', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $category->update($validated);
        return to_route('categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return to_route('categories.index');
    }
}
