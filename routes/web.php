<?php

use App\Http\Controllers\Admin\CategoryConrtoller;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\ClientProductController;
use App\Http\Controllers\client\HomeController;
use App\Http\Controllers\Client\Ordercontroller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ThongKeController;
use App\Http\Controllers\Client\AaController;
use App\Http\Controllers\Client\MyProfile;
use App\Http\Controllers\Client\Setting;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/






//----------------------------------------------------------------

// Định tuyến cho trang chính của người dùng
Route::get('/', [HomeController::class, 'index'])->name('client2.home');

// Định tuyến cho trang cài đặt hồ sơ của người dùng
Route::get('setting-profile', [MyProfile::class, 'index'])->name('profile-setting.index');
// Đường dẫn này cho phép người dùng xem và chỉnh sửa hồ sơ của họ
Route::post('setting-profile/update/{id}', [MyProfile::class, 'update'])->name('profile.update');
// Đường dẫn này cho phép người dùng cập nhật mật khẩu của họ
Route::post('setting-profile/update-password/{id}', [MyProfile::class, 'updatePassword'])->name('profile.update.password');

// Định tuyến cho việc tìm kiếm sản phẩm
Route::get('/products/search', [ClientProductController::class, 'search'])->name('client2.products.search');
// Định tuyến cho việc tìm kiếm sản phẩm từ trang chủ
Route::get('/products/home/search', [HomeController::class, 'search'])->name('client2.home.search');

// Định tuyến cho việc hiển thị danh sách sản phẩm theo danh mục
Route::get('product/{category_id}', [ClientProductController::class, 'index'])->name('client2.products.index');
// Định tuyến cho việc hiển thị chi tiết sản phẩm
Route::get('product-detail/{id}', [ClientProductController::class, 'show'])->name('client2.products.show');

// Bảo vệ các tuyến đường dưới đây: chỉ người dùng đã đăng nhập mới có thể truy cập
Route::middleware('auth')->group(function () {
    // Định tuyến cho việc thêm sản phẩm vào giỏ hàng
    Route::post('add-to-cart', [CartController::class, 'store'])->name('client2.carts.add');
    // Định tuyến cho việc hiển thị giỏ hàng
    Route::get('carts', [CartController::class, 'index'])->name('client2.carts.index');
    // Định tuyến cho việc cập nhật số lượng sản phẩm trong giỏ hàng
    Route::post('update-quantity-product-in-cart/{cart_product_id}', [CartController::class, 'updateQuantityProduct'])->name('client2.carts.update_product_quantity');
    // Định tuyến cho việc xóa sản phẩm khỏi giỏ hàng
    Route::post('remove-product-in-cart/{cart_product_id}', [CartController::class, 'removeProductInCart'])->name('client2.carts.remove_product');
    // Định tuyến cho trang thanh toán
    Route::get('checkout', [CartController::class, 'checkout'])->name('client2.checkout.index')->middleware('user.can_checkout_cart');
    // Xử lý thanh toán
    Route::post('proccess-checkout', [CartController::class, 'proccessCheckout'])->name('client2.checkout.proccess')->middleware('user.can_checkout_cart');
    // Định tuyến cho việc hiển thị danh sách đơn hàng của người dùng
    Route::get('list-order', [Ordercontroller::class, 'index'])->name('client2.orders.index');
    // Định tuyến cho việc hủy đơn hàng
    Route::post('orders/cancel/{id}', [Ordercontroller::class, 'cancel'])->name('client2.orders.cancel');
});


// Định tuyến cho các tác vụ đăng nhập, đăng ký, đăng xuất
Auth::routes();

// Định tuyến cho trang chính của người dùng
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Bảo vệ các tuyến đường dưới đây: chỉ người dùng đã đăng nhập mới có thể truy cập
Route::middleware('auth')->group(function () {

    // Định tuyến cho trang dashboard, chỉ quản trị viên mới có quyền truy cập
    Route::get('/dashboard', function () {
        return view('admin.dashboard.index');
    })->name('dashboard');

    // Định tuyến cho quản lý vai trò
    Route::prefix('roles')->controller(RoleController::class)->name('roles.')->group(function () {
        // Tuyến đường hiển thị danh sách vai trò
        Route::get('/', 'index')->name('index')->middleware('role:super-admin|admin');
        // Tuyến đường lưu vai trò mới
        Route::post('/', 'store')->name('store')->middleware('role:super-admin|admin');
        // Tuyến đường hiển thị form tạo mới vai trò
        Route::get('/create', 'create')->name('create')->middleware('role:super-admin|admin');
        // Tuyến đường hiển thị chi tiết vai trò
        Route::get('/{coupon}', 'show')->name('show')->middleware('role:super-admin|admin');
        // Tuyến đường cập nhật vai trò
        Route::put('/{coupon}', 'update')->name('update')->middleware('role:super-admin|admin');
        // Tuyến đường xóa vai trò
        Route::delete('/{coupon}', 'destroy')->name('destroy')->middleware('role:super-admin|admin');
        // Tuyến đường hiển thị form chỉnh sửa vai trò
        Route::get('/{coupon}/edit', 'edit')->name('edit')->middleware('role:super-admin|admin');
    });

    // Định tuyến cho quản lý người dùng
    Route::prefix('users')->controller(UserController::class)->name('users.')->group(function () {
        // Tuyến đường hiển thị danh sách người dùng
        Route::get('/', 'index')->name('index')->middleware('permission:show-user');
        // Tuyến đường lưu người dùng mới
        Route::post('/', 'store')->name('store');
        // Tuyến đường hiển thị form tạo mới người dùng
        Route::get('/create', 'create')->name('create')->middleware('permission:create-user');
        // Tuyến đường hiển thị chi tiết người dùng
        Route::get('/{coupon}', 'show')->name('show')->middleware('permission:show-user');
        // Tuyến đường cập nhật người dùng
        Route::put('/{coupon}', 'update')->name('update')->middleware('permission:update-user');
        // Tuyến đường xóa người dùng
        Route::delete('/{coupon}', 'destroy')->name('destroy')->middleware('permission:delete-user');
        // Tuyến đường hiển thị form chỉnh sửa người dùng
        Route::get('/{coupon}/edit', 'edit')->name('edit')->middleware('permission:update-user');
    });

    // Định tuyến cho quản lý danh mục sản phẩm
    Route::prefix('categories')->controller(CategoryConrtoller::class)->name('categories.')->group(function () {
        // Tuyến đường hiển thị danh sách danh mục sản phẩm
        Route::get('/', 'index')->name('index')->middleware('permission:show-category');
        // Tuyến đường lưu danh mục sản phẩm mới
        Route::post('/', 'store')->name('store')->middleware('permission:show-category');
        // Tuyến đường hiển thị form tạo mới danh mục sản phẩm
        Route::get('/create', 'create')->name('create')->middleware('permission:create-category');
        // Tuyến đường hiển thị chi tiết danh mục sản phẩm
        Route::get('/{coupon}', 'show')->name('show')->middleware('permission:show-category');
        // Tuyến đường cập nhật danh mục sản phẩm
        Route::put('/{coupon}', 'update')->name('update')->middleware('permission:update-category');
        // Tuyến đường xóa danh mục sản phẩm
        Route::delete('/{coupon}', 'destroy')->name('destroy')->middleware('permission:delete-category');
        // Tuyến đường hiển thị form chỉnh sửa danh mục sản phẩm
        Route::get('/{coupon}/edit', 'edit')->name('edit')->middleware('permission:update-category');
    });

    // Định tuyến cho quản lý sản phẩm
    Route::prefix('products')->controller(ProductController::class)->name('products.')->group(function () {
        // Tuyến đường hiển thị danh sách sản phẩm
        Route::get('/', 'index')->name('index')->middleware('permission:show-product');
        // Tuyến đường lưu sản phẩm mới
        Route::post('/', 'store')->name('store')->middleware('permission:create-product');
        // Tuyến đường hiển thị form tạo mới sản phẩm
        Route::get('/create', 'create')->name('create')->middleware('permission:create-product');
        // Tuyến đường hiển thị chi tiết sản phẩm
        Route::get('/{coupon}', 'show')->name('show')->middleware('permission:show-product');
        // Tuyến đường cập nhật sản phẩm
        Route::put('/{coupon}', 'update')->name('update')->middleware('permission:update-product');
        // Tuyến đường xóa sản phẩm
        Route::delete('/{coupon}', 'destroy')->name('destroy')->middleware('permission:delete-product');
        // Tuyến đường hiển thị form chỉnh sửa sản phẩm
        Route::get('/{coupon}/edit', 'edit')->name('edit')->middleware('permission:update-product');
    });

    // Định tuyến cho trang thống kê
    Route::get('/thong-ke', [ThongKeController::class, 'index'])->name('thongke');

    // Định tuyến cho việc hiển thị danh sách đơn hàng của quản trị viên
    Route::get('orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    // Định tuyến cho việc cập nhật trạng thái đơn hàng
    Route::put('update-status/{id}', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update_status');
});
