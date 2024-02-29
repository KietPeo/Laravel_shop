  <!-- Featured Start -->
  @extends('client2.layouts.index')
  @section('title', 'Cart')
  @section('content')


      <div class="row px-xl-5">
        @if (session('message'))
        <div class="row">
            <h3 class="text-danger">{{ session('message') }}</h3>
        </div>
    @endif
          <div class="col-lg-8 table-responsive mb-5">
              <table class="table table-bordered text-center mb-0">
                  <thead class="bg-secondary text-dark">
                      <tr>
                          <th>Hình Ảnh</th>
                          <th>Sản Phẩm</th>
                          <th>Giá</th>
                          <th>Size</th>
                          <th>Giảm Giá</th>
                          <th>Số Lượng</th>
                          <th>Tổng</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody class="align-middle">
                      @foreach ($cart->products as $item)
                            <tr id="row-{{ $item->id }}">
                                <td>
                                    <img src="{{ $item->product->image_path }}" alt="{{ $item->product->name }}" style="width: 50px;">
                                </td>
                                <td class="align-middle">
                                   
                                    {{ $item->product->name }}
                                </td>
                              <td class="align-middle">
                                  <p
                                      style="{{ $item->product->sale ? 'text-decoration: line-through' : '' }};                                                                                                                                                                                                                                                 ">
                                      ${{ $item->product->price }}
                                  </p>

                                  @if ($item->product->sale)
                                      <p
                                          style="
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ">
                                          ${{ $item->product->sale_price }}
                                      </p>
                                  @endif
                              </td>
                              <td class="align-middle">{{ $item->product_size }}</td>
                              <td class="align-middle">{{ $item->product->sale }}</td>
                              <td class="align-middle px-5">
                                  <div class="input-group quantity mx-auto" style="width: 100px;">
                                      <div class="input-group-btn">
                                          <button  class="btn btn-sm  btn-primary btn-minus btn-update-quantity"
                                              data-action="{{route('client2.carts.update_product_quantity',$item->id)}}"
                                              data-id="{{ $item->id }}">
                                              <i class="fa fa-minus"></i>
                                          </button>
                                      </div>
                                     <div class="">
                                        <input type="number" class="form-control form-control-sm bg-secondary text-center p-0 mx-3"
                                        id="productQuantityInput-{{ $item->id }}" min="0"
                                        value="{{ $item->product_quantity }}">
                                     </div>
                                      <div class="input-group-btn">
                                          <button class="btn btn-sm btn-primary btn-plus btn-update-quantity ms-4"
                                          data-action="{{route('client2.carts.update_product_quantity',$item->id)}}"
                                              data-id="{{ $item->id }}">
                                              <i class="fa fa-plus"></i>
                                          </button>
                                      </div>
                                      

                              </td>
                              <td class="align-middle">
                                  <span
                                      id="cartProductPrice{{ $item->id }}">
                                      ${{ $item->product->sale ? $item->product->sale_price * $item->product_quantity : $item->product->price * $item->product_quantity }}
                                    </span>

                              </td>
                              <td class="align-middle">
                                  <button class="btn btn-sm btn-primary btn-remove-product"
                                      data-action="{{route('client2.carts.remove_product',$item->id)}}"><i
                                          class="fa fa-times"></i></button>
                              </td>
                          </tr>
                      @endforeach

                  </tbody>
              </table>
          </div>
          <div class="col-lg-4">
              <div class="card border-secondary mb-5">
                  <div class="card-header bg-secondary border-0">
                      <h4 class="font-weight-semi-bold m-0">Tổng Giỏ hàng</h4>
                  </div>
                  <div class="card-body">
                      <div class="d-flex justify-content-between mb-3 pt-1">
                          <h6 class="font-weight-medium">Tổng</h6>
                          <h6 class="font-weight-medium total-price" data-price="{{ $cart->total_price }}">
                              ${{ $cart->total_price }}</h6>
                      </div>


                    

                  </div>
                  <div class="card-footer border-secondary bg-transparent">
                      <div class="d-flex justify-content-between mt-2">
                          <h5 class="font-weight-bold">Tổng Tiền</h5>
                          <h5 class="font-weight-bold total-price total-price-all"></h5>
                      </div>
                      <a href="{{route('client2.checkout.index')}}" class="btn btn-block btn-primary my-3 py-3">Thanh Toán</a>
                  </div>
              </div>
          </div>
      </div>
      <script>
       // Product Quantity
    $('.quantity button').off('click').on('click', function () {
        var button = $(this);
        var oldValue = parseFloat(button.parent().parent().find('input').val());
        console.log('đây 1 :'+oldValue);
        if (button.hasClass('btn-plus')) {
            var newVal = parseFloat(oldValue) + 1;
            console.log('đây  2:'+newVal);
        } else {
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        button.parent().parent().find('input').val(newVal);
    });
        </script>

  @endsection
  @section('script')
      {{-- <script src="{{ asset('client/cart/cart.js') }}"></script> --}}
      <script>
    $(function () {
    let isUpdating = false; // Biến để kiểm tra xem hàm xử lý có đang được gọi không

    getTotalValue();

    function getTotalValue() {
        let total = $(".total-price").data("price");
        let couponPrice = $(".coupon-div")?.data("price") ?? 0;
        $(".total-price-all").text(`$${total - couponPrice}`);
    }

    $(document).on("click", ".btn-remove-product", function (e) {
        if (isUpdating) return; // Nếu hàm xử lý đang được gọi, không thực hiện thêm

        let url = $(this).data("action");
        confirmDelete()
            .then(function () {
                isUpdating = true; // Đặt cờ là true khi bắt đầu thực hiện hàm xử lý
                $.post(url, (res) => {
                    let cart = res.cart;
                    let cartProductId = res.product_cart_id;
                    $("#productCountCart").text(cart.product_count);
                    $(".total-price")
                        .text(`$${cart.total_price}`)
                        .data("price", cart.product_count);
                    $(`#row-${cartProductId}`).remove();
                    getTotalValue();
                });
            })
            .catch(function () {})
            .finally(() => {
                isUpdating = false; // Đặt cờ là false khi hàm xử lý đã hoàn thành
            });
    });

    $(document).off("click", ".btn-update-quantity").on("click", ".btn-update-quantity", function (e) {
    if (isUpdating) return; // Nếu hàm xử lý đang được gọi, không thực hiện thêm

    let url = $(this).data("action");
    let id = $(this).data("id");
    let data = {
        product_quantity: $(`#productQuantityInput-${id}`).val(),
    };

    isUpdating = true; // Đặt cờ là true khi bắt đầu thực hiện hàm xử lý

    $.post(url, data, (res) => {
        let cartProductId = res.product_cart_id;
        let cart = res.cart;
        $("#productCountCart").text(cart.product_count);
        if (res.remove_product) {
            $(`#row-${cartProductId}`).remove();
        } else {
            $(`#cartProductPrice${cartProductId}`).html(
                `$${res.cart_product_price}`
            );
        }
        getTotalValue();
        $(".total-price").text(`$${cart.total_price}`);
        Swal.fire({
            position: "top-center",
            icon: "success",
            title: "success",
            showConfirmButton: false,
            timer: 2000,
        });
    }).fail(function () {
        // Xử lý lỗi ở đây nếu cần
    }).always(() => {
        isUpdating = false; // Đặt cờ là false khi hàm xử lý đã hoàn thành
    });
});
});


    </script>
  @endsection
