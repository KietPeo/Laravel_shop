@extends('client2.layouts.index2')
@section('title', 'product detail')
@section('content')
    <!-- Page Header Start -->
    <div class="row" style="margin-left: 50px">
        <div class="d-inline-flex">
            <p class="m-0"><a href="">Home</a></p>
            <p class="m-0 px-2">/</p>
            <p class="m-0">Shop Detail</p>
        </div>
    </div>
    <!-- Page Header End -->
    @if (session('message'))
        {{-- <h2 class="" style="text-align: center; width:100%; color:red"> {{ session('message') }}</h2> --}}
        @if (session('message'))
            <script>
                alert('{{ session('message') }}');
            </script>
        @endif
    @endif


    <section class="py-5">
        <div class="container">
            <form action="{{ route('client2.carts.add') }}" method="POST" class="row px-xl-5">
                @csrf
            <div class="row gx-5">
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <aside class="col-lg-6">
                    <div class="border rounded-4 mb-3 d-flex justify-content-center">
                        <a data-fslightbox="mygalley" class="rounded-4" target="_blank" data-type="image"
                            href="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/detail1/big.webp">
                            <img style="max-width: 100%; max-height: 100vh; margin: auto;" class="rounded-4 fit"
                                src="{{ $product->images->count() > 0 ? asset('upload/' . $product->images->first()->url) : 'upload/default.png' }}"
                                alt="Image">
                        </a>
                    </div>
                </aside>
                <main class="col-lg-6">
                    <div class="ps-lg-3">
                        <h4 class="title text-dark">
                            {{ $product->name }}
                        </h4>
                        <div class="d-flex flex-row my-3">
                            <div class="text-warning mb-1 me-2">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span class="ms-1">
                                    4.5
                                </span>
                            </div>
                            <span class="text-muted"><i class="fas fa-shopping-basket fa-sm mx-1"></i>154 orders</span>
                            <span class="text-success ms-2">In stock</span>
                        </div>

                        <div class="mb-3">
                            <span class="h5">${{ $product->price }}</span>
                            <del>${{ $product->sale }}</del>
                            <span class="text-muted">/per box</span>
                        </div>

                        <p>
                            {!! $product->description !!}
                        </p>


                        <hr />

                        <div class="d-flex mb-4">
                            <p class="text-dark font-weight-medium mb-0 mr-3">Size:</p>
                            @if ($product->details->count() > 0)
                                @foreach ($product->details as $size)
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="product_size"
                                            value="{{ $size->sizes }}" id="size{{ $size->sizes }}">
                                        <label for="size{{ $size->sizes }}"
                                            class="custom-control-label">{{ $size->sizes }}</label>
                                    </div>
                                @endforeach
                            @else
                                <p>Hết hàng</p>
                            @endif

                        </div>
                        <div class="d-flex align-items-center mb-4 pt-2">
                            {{-- ở đây nút button + và - và add to card đều là submit nếu ta không đặt type cho nó thì khi nhấn + hoặc - nó điều là submit --}}
                            <div class="input-group quantity mr-3" style="width: 130px;">
                                <div class="input-group-btn">
                                    <button type='button' class="btn btn-primary btn-minus">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                               
                                <div class="">
                                    <input type="text" name="product_quantity" class="form-control bg-secondary text-center mx-1" value="1" style="width: 50px;">
                                </div>
                              
                                <div class="input-group-btn">
                                    <button type='button' class="btn btn-primary btn-plus mx-2">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="ms-5">
                                <button class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To
                                    Cart</button>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            </form>
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
    </section>

@endsection
