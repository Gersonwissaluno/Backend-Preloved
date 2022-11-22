<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function apiIndex()
    {
        $product = Product::with('category')->get();
        $message = "Product Data loaded Successfully";
        return response()->json(compact('message', 'product'), 200);
    }

    public function showByCategory($id)
    {
        $product = Product::where('category_id', $id)->get();
        $message = "Product Data loaded Successfully";
        return response()->json(compact('message', 'product'), 200);
    }

    public function apiStore(Request $request)
    {
        if ($request->hasFile('thumbnail')) {
            $save = $request->file('thumbnail')->store('public/image');
            $filename = $request->file('thumbnail')->hashName();
            $imagePath = url('/') . '/storage/image/' . $filename;
        }

        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'thumbnail' => $imagePath,
            'price' => $request->price,
        ]);

        $status = 'OK';
        $status_code = '200';
        $message = 'Berhasil Menambahkan data';
        return response()->json(compact('status', 'status_code', 'message', 'product'), 200);
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(product $product, $id)
    {
        $product = Product::findOrFail($id);
        if ($product) {
            $product->delete();
            $status = 'OK';
            $status_code = '200';
            $message = 'Berhasil Menghpaus data';
            return response()->json(compact('status', 'status_code', 'message'), 200);
        } else {
            $status = 'ERR';
            $status_code = '401';
            $message = 'Gagal Menghapus';
            return response()->json(compact('status', 'status_code', 'message'), 401);
        }
    }
}
