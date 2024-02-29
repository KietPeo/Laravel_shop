@extends('client2.layouts.index')
@section('title','Home')
@section('content')
<section id="mobile-products" class="product-store position-relative padding-large no-padding-top">
    <div class="container">
      <div class="row">
        <div class="col-12 pb-1">
          <div class="d-flex align-items-center justify-content-between mb-4">
              <form action="{{ route('client2.home.search') }}" method="GET">
                  <div class="input-group">
                      <input type="text" class="form-control" placeholder="Search by name" name="search" id="searchInput">
                      <div class="input-group-append">
                          <button type="submit" class="input-group-text bg-transparent text-primary">
                              <i class="fa fa-search"></i>
                          </button>
                      </div>
                  </div>
              </form>
          </div>
        <div class="display-header d-flex justify-content-between pb-3">
          <h2 class="display-7 text-dark text-uppercase">Sản Phẩm</h2>
          {{-- <div class="btn-right">
            <a href="shop.html" class="btn btn-medium btn-normal text-uppercase">Go to Shop</a>
          </div> --}}
        </div>
        <div class="swiper product-swiper">
          <div class="swiper-wrapper">
            @foreach ($products as $item)

            <div class="swiper-slide">
              <div class="product-card position-relative">
                <div class="image-holder">
                  <img  src="{{ $item->images->count() > 0 ? asset('upload/' . $item->images->first()->url) : 'upload/default.png' }}"
                   alt="product-item" class="img-fluid">
                </div>
                <div class="cart-concern position-absolute">
                  <div class="cart-button d-flex">
                    <a href="{{ route('client2.products.show', $item->id) }}" class="btn btn-medium btn-black">View Detail
                      <svg class="cart-outline"><use xlink:href="#cart-outline"></use></svg></a>
                  </div>
                </div>
                <div class="card-detail text-center justify-content-between align-items-baseline pt-3">
                  <h3 class="card-title text-uppercase">
                    <a href="{{ route('client2.products.show', $item->id) }}">{{ $item->name }}</a>
                  </h3>
                  <span class="item-price text-primary">
                    ${{ $item->price }}
                    {{-- <del>${{ $item->price }}</del> --}}
                </span>
                </div>
              </div>
            </div>
            @endforeach ()
          </div>
        </div>
      </div>
      {{ $products->links() }}
    </div>
    <div class="swiper-pagination position-absolute text-center"> aaaa</div>
  </section>
  @endsection