<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('admin.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::latest()->get();
        return view('admin.blog.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'headline' => 'required',
            'content' => 'required',
            'product_id' => Rule::requiredIf($request->category == 'resep'),
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
        ]);

        if ($request->hasFile('image')) {
            $request->image->store('public/blogs');
            $image = $request->image->hashName();
        }

        Blog::create([
            'title' => $request->title,
            'slug' => str()->slug($request->title),
            'headline' => $request->headline,
            'content' => $request->content,
            'category' => $request->category,
            'product_id' => $request->product_id ?? null,
            'image' => $image,
            'author_id' => auth()->user()->id,
        ]);

        return redirect()->route('blog.index')->with('success', 'Artikel berhasil ditambah!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        $products = Product::latest()->get();
        return view('admin.blog.edit', compact('blog', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required',
            'headline' => 'required',
            'content' => 'required',
            'product_id' => Rule::requiredIf($request->category == 'resep'),
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10048',
        ]);

        if ($request->hasFile('image')) {
            File::delete(public_path('storage/blogs/' . $blog->image));
            $request->image->store('public/blogs');
            $image = $request->image->hashName();
        }

        $blog->update([
            'title' => $request->title,
            'slug' => str()->slug($request->title),
            'headline' => $request->headline,
            'content' => $request->content,
            'category' => $request->category,
            'product_id' => $request->product_id ?? null,
            'image' => $image ?? $blog->image,
        ]);

        return redirect()->route('blog.index')->with('success', 'Artikel berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  Blog $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        File::delete(public_path('storage/blogs/' . $blog->image));
        $blog->delete();

        return redirect()->route('blog.index')->with('success', 'Artikel berhasil dihapus!');
    }
}
