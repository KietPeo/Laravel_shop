<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Providers\CategoryComposer;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $product;
    public function __construct(Product  $product)
    {
        // $this->middleware('auth');
        $this->product = $product;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Lấy tất cả sản phẩm ra màn hình
        $products = $this->product->where('sale', '>', 0)->latest('id')->paginate(5);
        // Lọc những sản phẩm có giá trị "sale" lớn hơn 0
        return view('client2.home.index', compact('products'));
    }
    
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        // Thực hiện tìm kiếm sản phẩm dựa trên tên sản phẩm
        $products = $this->product->where('name', 'like', "%{$searchTerm}%")->paginate(4);

        return view('client2.home.index', compact('products'));
    }
}
