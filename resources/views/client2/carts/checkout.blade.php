@extends('client2.layouts.index')
@section('title', 'Cart')
@section('content')
    <div class="container-fluid pt-5">
        <form class="row px-xl-5" method="POST" action="{{ route('client2.checkout.proccess') }}">
            @csrf
            @if (session('message'))
        {{-- <h2 class="" style="text-align: center; width:100%; color:red"> {{ session('message') }}</h2> --}}
        @if (session('message'))
            <script>
                alert('{{ session('message') }}');
            </script>
        @endif
    @endif
   
            <div class="col-lg-8">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Thanh Toán</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Họ Tên</label>
                            <input class="form-control" value="{{ old('customer_name') }}" name="customer_name"
                                type="text" placeholder="Họ Tên">
                            @error('customer_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror ()

                        </div>

                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" name="customer_email" value="{{ old('customer_email') }}"
                                type="text" placeholder="example@email.com">
                            @error('customer_email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror ()
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Số Điện Thoại</label>
                            <input class="form-control" name="customer_phone" value="{{ old('customer_phone') }}"
                                type="text" placeholder="+84-123-456-789">
                            @error('customer_phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror ()
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Địa Chỉ </label>
                            <input class="form-control" name="customer_address" value="{{ old('customer_address') }}"
                                type="text" placeholder="Thành Phố Hồ Chí Minh ....">
                            @error('customer_address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror ()
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Ghi Chú </label>
                            <input class="form-control" value="{{ old('note') }}" name="note" type="text"
                                placeholder="Ghi chú">
                            @error('note')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror ()
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Tổng đơn hàng</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-medium mb-3">Sản Phẩm</h5>
                        @foreach ($cart->products as $item)
                            <div class="d-flex justify-content-between">
                                <p> {{ $item->product_quantity }} x {{ $item->product->name }}</p>
                                <p></p>
                                <p
                                    style="
                                                                                                                                                                                                                                                                                                                                                                {{ $item->product->sale ? 'text-decoration: line-through' : '' }};
                                                                                                                                                                                                                                                                                                                                                                                                                      ">
                                    ${{ $item->product_quantity * $item->product->price }}
                                </p>

                                @if ($item->product->sale)
                                    <p
                                        style="
                                                                                                                                                                                                                                                                                                                                                                                                                            ">
                                        ${{ $item->product_quantity * $item->product->sale_price }}
                                    </p>
                                @endif

                            </div>
                        @endforeach
                        <hr class="mt-0">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Tổng cộng</h6>
                            <h6 class="font-weight-medium total-price" data-price="{{ $cart->total_price }}">
                                ${{ $cart->total_price }}</h6>

                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Phí Ship</h6>
                            <h6 class="font-weight-medium shipping" data-price="20">$20</h6>
                            <input type="hidden" value="20" name="ship">

                        </div>
                        @if (session('discount_amount_price'))
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Coupon </h6>
                                <h6 class="font-weight-medium coupon-div"
                                    data-price="{{ session('discount_amount_price') }}">
                                    ${{ session('discount_amount_price') }}</h6>
                            </div>
                        @endif

                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Tổng</h5>
                            <h5 class="font-weight-bold total-price-all"></h5>
                            <input type="hidden" id="total" value="" name="total">
                        </div>
                    </div>
                </div>
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Phương Thức Thanh Toán</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" checked value="monney" name="payment">
                                <label class="custom-control-label">
                                    Tiền Mặt
                                    <i class="bi bi-cash"></i>
                                </label>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <button class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3" type="submit">Thanh Toán</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script>
        $(function() {


            getTotalValue()

            function getTotalValue() {
                let total = $('.total-price').data('price')
                let couponPrice = $('.coupon-div')?.data('price') ?? 0;
                let shiping = $('.shipping').data('price')
                $('.total-price-all').text(`$${total + shiping - couponPrice}`)
                $('#total').val(total + shiping - couponPrice)
            }

        });
        
    </script>

@endsection
