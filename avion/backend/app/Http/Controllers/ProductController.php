<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function create(CreateProductRequest $request)
    {
        $p = new Product();
        $p->name = $request->name;
        $p->price = $request->price;
        $p->image = $request->image;
        $p->description = $request->description;
        $p->height = $request->height;
        $p->width = $request->width;
        $p->depth = $request->depth;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('products', $imageName, 'public');
            $p->image = 'storage/' . $imagePath;
        }

        $p->save();
    }

    public function getAll() {
        return Product::all();
    }

    public function show($id) {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
           'name' => 'nullable|string|max:255',
           'price' => 'nullable|numeric',
           'description' => 'nullable|string',
           'height' => 'nullable|numeric',
           'width' => 'nullable|numeric',
           'depth' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Обновляем поля продукта
        $product->fill($validated);

        // Обработка изображения
        if ($request->hasFile('image')) {
            // Удаление старого изображения
            if ($product->image && Storage::exists(str_replace('storage/', 'public/', $product->image))) {
                Storage::delete(str_replace('storage/', 'public/', $product->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('products', $imageName, 'public');
            $product->image = 'storage/' . $imagePath;
        }

        $product->save();

        return response()->json($product);


    }


    public function delete(Request $request, $id) {
        $product = Product::findOrFail($id);
        $product->delete();
    }

}
