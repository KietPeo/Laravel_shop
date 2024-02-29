<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ClientProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index(Request $request, $category_id)
    {
        $products = $this->product->getBy($request->all(), $category_id);
        return view('client2.products.index', compact('products'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        // Thực hiện tìm kiếm sản phẩm dựa trên tên sản phẩm
        $products = $this->product->where('name', 'like', "%{$searchTerm}%")->paginate(4);

        return view('client2.products.index', compact('products'));
    }
    
    // Trong hàm xử lý tìm kiếm của controller

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $product = $this->product->with('details')->findOrFail($id);
        return view('client2.products.detail', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
