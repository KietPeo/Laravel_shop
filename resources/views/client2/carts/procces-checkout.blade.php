@extends('client2.layouts.index')
@section('title', 'Payment Success')
@section('content')

<div class="container-fluid pt-5">
    <div class="row text-center">
        <div class="col-lg-12">
            @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
          
            <a href="{{ route('client2.home') }}" class="btn btn-primary">Quay lại trang chủ</a>
        </div>
    </div>
</div>
@endsection