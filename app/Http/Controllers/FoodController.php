<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $foods = Food::latest()->filter()->paginate(8)->withQueryString();
        return view('admin.foods.index', compact('foods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.foods.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'satuan' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
        ]);

        if ($request->hasFile('image')) {
            $request->image->store('public/foods');
            $image = $request->image->hashName();
        }

        Food::create([
            'name' => $request->name,
            'slug' => str()->slug($request->name),
            'satuan' => $request->satuan,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $image,
        ]);

        return redirect()->route('foods.index')->with('success', 'Makanan berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Food $food)
    {
        return view('admin.foods.edit', compact('food'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Food $food)
    {
        $this->validate($request, [
            'name' => 'required',
            'satuan' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10048',
        ]);

        if ($request->hasFile('image')) {
            File::delete(public_path('storage/foods/' . $food->image));
            $request->image->store('public/foods');
            $image = $request->image->hashName();
        }

        $food->update([
            'name' => $request->name,
            'slug' => str()->slug($request->name),
            'satuan' => $request->satuan,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $image ?? $food->image,
        ]);

        return redirect()->route('foods.index')->with('success', 'Makanan berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  Food $food
     * @return \Illuminate\Http\Response
     */
    public function destroy(Food $food)
    {
        File::delete(public_path('storage/foods/' . $food->image));
        $food->delete();

        return redirect()->route('foods.index')->with('success', 'Makanan berhasil dihapus');
    }
}
