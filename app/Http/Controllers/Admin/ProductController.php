<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\CreateProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $category;
    protected $product;
    protected $productDetail;
    public function __construct(ProductDetail $productDetail, Product $product, Category $category)
    {
        $this->product = $product;
        $this->category = $category;
        $this->productDetail = $productDetail;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = $this->product::latest('id')->paginate(5);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // chúng ta phải lấy ra categories để biết product này của categorie nào
        $categories = $this->category::get(['id', 'name']);
        return view('admin.products.create', compact('categories'));
    }


    public function store(CreateProductRequest $request)
    {
        // Lấy dữ liệu từ form, loại bỏ trường 'sizes' nếu có
        $dataCreate = $request->except('sizes');
        // Kiểm tra xem dữ liệu sizes đã được giải mã từ JSON hay chưa
        $sizes = $request->sizes;
        // Dòng này kiểm tra xem có dữ liệu về kích thước của sản phẩm được gửi không. 
        // Nếu có, nó sẽ giải mã dữ liệu JSON và lưu vào biến $sizes, nếu không, nó sẽ gán một mảng trống cho biến $sizes.
        if (!is_array($sizes)) {
            $sizes = json_decode($sizes, true);
        }
        // Tạo mới sản phẩm và lưu vào cơ sở dữ liệu
        $product = Product::create($dataCreate);
        // Lưu hình ảnh vào thư mục và cập nhật đường dẫn hình ảnh vào dữ liệu sản phẩm
        $dataCreate['image'] = $this->product->saveImage($request);
        // Tạo mới một bản ghi trong bảng images và liên kết với sản phẩm
        $product->images()->create(['url' => $dataCreate['image']]);
        // Dòng này thiết lập quan hệ nhiều nhiều giữa sản phẩm và danh mục.Nó liên kết các danh mục được chọn từ form với sản phẩm mới được tạo.
        $product->categories()->attach($dataCreate['category_ids']);
        // Tạo một mảng chứa thông tin về kích thước và số lượng của sản phẩm
        // Dòng này tạo một mảng $sizeArray chứa thông tin về kích thước và số lượng của sản phẩm.
        //  Mỗi phần tử trong mảng này sẽ được sử dụng để tạo bản ghi mới trong bảng product_details.
        $sizeArray = [];
        foreach ($sizes as $size) {
            $sizeArray[] = ['sizes' => $size['size'], 'quantity' => $size['quantity'], 'product_id' => $product->id];
        }
        // Chèn các bản ghi mới vào bảng product_details
        $this->productDetail->insert($sizeArray);
        // dd($sizeArray);
        return redirect()->route('products.index')->with(['message' => 'Create product successfully']);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $product = $this->product->with('details', 'categories')->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $product = $this->product->with('details', 'categories')->findOrFail($id);
        $categories = $this->category::get(['id', 'name']);
        return view('admin.products.edit', compact('categories', 'product'));
    }




    public function update(UpdateProductRequest $request, string $id)
    {
        $dataUpdate = $request->except('sizes');
        $sizes = $request->sizes ?? [];

        $product = $this->product->findOrFail($id);

        $currentImage = $product->images ? $product->images->first()->url : '';
        $dataUpdate['image'] = $this->product->updateImage($request, $currentImage);

        $product->update($dataUpdate);
        $product->images()->delete();
        $product->images()->updateOrcreate(['url' => $dataUpdate['image']]);
        // Xóa các chi tiết sản phẩm chỉ khi có thay đổi về kích thước
        if (!empty($sizes)) {
            $product->details()->delete();
        }
        // Tạo một mảng chứa thông tin về kích thước và số lượng của sản phẩm
        $sizeArray = [];
        foreach ($sizes as $size) {
            $sizeArray[] = ['sizes' => $size['size'], 'quantity' => $size['quantity'], 'product_id' => $product->id];
        }
        $this->productDetail->insert($sizeArray);

        // Liên kết sản phẩm với danh mục được chọn từ form
        $product->assignCategory($dataUpdate['category_ids']);

        return redirect()->route('products.index')->with(['message' => 'Update successfully']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // phải lấy ra được product
        $product = $this->product->findOrFail($id);
        $product->delete();
        $product->details()->delete();
        //  xóa luôn ảnh
        $currentImage = $product->images->count() > 0 ? $product->images->first()->url : '';
        $this->product->dateleImage($currentImage);
        return redirect()->route('products.index')->with(['message' => 'Delete successfully']);
    }
}
