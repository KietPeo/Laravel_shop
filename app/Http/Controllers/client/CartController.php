<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\CreateOrderRequest;
use App\Http\Resources\Cart\CartResource;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Coupon;
use App\Models\Oder;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $cart;
    protected $product;
    protected $cartProduct;
    protected $coupon;
    protected $oder;
    public function __construct(Product $product, Cart $cart, CartProduct $cartProduct, Coupon  $coupon, Oder $oder)
    {
        $this->product = $product;
        $this->cart = $cart;
        $this->cartProduct = $cartProduct;
        $this->coupon = $coupon;
        $this->oder = $oder;
    }
    public function index()
    {
        //----------------------------------------------------------------
        $cart = $this->cart->firstOrCreateBy(auth()->user()->id)->load('products');
        return view('client2.carts.index', compact('cart'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        if (auth()->check()) {
            if ($request->product_size) {
                $product = $this->product->findOrFail($request->product_id);
                $cart = $this->cart->firstOrCreateBy(auth()->user()->id);
                $cartProduct = $this->cartProduct->getBy($cart->id, $product->id, $request->product_size);
                if ($cartProduct) {
                    $quantity = $cartProduct->product_quantity;
                    $cartProduct->update(['product_quantity' => ($quantity + $request->product_quantity)]);
                    return back()->with(['message' => 'Sản Phẩm Đã Có Trong Giỏ Rồi']);
                } else {
                    $dataCreate = [
                        'cart_id' => $cart->id,
                        'product_size' => $request->product_size,
                        'product_quantity' => $request->product_quantity ?? 1,
                        'product_price' => $product->price,
                        'product_id' => $request->product_id,
                        'user_id' => auth()->user()->id, // Associate with the authenticated user
                    ];
                    $this->cartProduct->create($dataCreate);
                }
                return back()->with(['message' => 'Thêm thành công']);
            } else {
                return back()->with(['message' => 'Bạn chưa chọn Size']);
            }
        } else {
            return redirect()->route('login')->with(['message' => 'Vui lòng đăng nhập để thêm vào giỏ hàng']);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    public function removeProductInCart($id)
    {
        $cartProduct = $this->cartProduct->find($id);
        $cartProduct->delete();
        $cart = $cartProduct->cart;
        return response()->json([
            'product_cart_id' => $id,
            'cart' => new CartResource($cart)
        ], Response::HTTP_OK);
    }
    public function updateQuantityProduct(Request $request, $id)
    {

        $cartProduct = $this->cartProduct->find($id);
        $dataUpdate = $request->all();

        if ($dataUpdate['product_quantity'] < 1) {
            $cartProduct->delete();
        } else {
            $cartProduct->update($dataUpdate);
        }

        // Tính toán giá sản phẩm mới
        $cartProductPrice = $cartProduct->product->sale ? $cartProduct->product->sale_price : $cartProduct->product->price;
        $cartProductPrice *= $dataUpdate['product_quantity'];

        $cart = $cartProduct->cart;

        // Trả về thông tin sản phẩm cập nhật cùng giá sản phẩm mới
        return response()->json([
            'product_cart_id' => $id,
            'cart' => new CartResource($cart),
            'cart_product_price' => $cartProductPrice, // Trả về giá sản phẩm mới
            'remove_product' => $dataUpdate['product_quantity'] < 1,
            'cart_product_price' => $cartProduct->total_price,
        ], Response::HTTP_OK);
    }
    public function checkout()
    {
        $cart = $this->cart->firstOrCreateBy(auth()->user()->id)->load('products');
        return view('client2.carts.checkout', compact('cart'));
    }
    public function proccessCheckout(CreateOrderRequest $request)
    {
        // dd($request->all());
        $dataCreate = $request->all();
        $dataCreate['user_id'] = auth()->user()->id;
        $dataCreate['status'] = 'pending';
        $this->oder->create($dataCreate);
        $couponID = Session::get('coupon_id');
        if ($couponID) {
            $coupon =  $this->coupon->find(Session::get('coupon_id'));
            if ($coupon) {
                $coupon->users()->attach(auth()->user()->id, ['value' => $coupon->value]);
            }
        }
        // $cart = $this->cart->firtOrCreateBy(auth()->user()->id);
        $cart = $this->cart->firstOrCreateBy(auth()->user()->id);
        $cart->products()->delete();
        // Session::forget(['coupon_id', 'discount_amount_price', 'coupon_code']);
        Session::forget(['coupon_id', 'discount_amount_price', 'coupon_code']);
        // Pass the success message to the view
        session()->flash('message', 'Thanh toán thành công');
        // return view('client.carts.procces-checkout')->with(['message' =>'Thanh Toán Thành Công']);
        return view('client2.carts.procces-checkout')->with(['message' => 'Thanh Toán Thành Công']);
    }
}
