@extends('client.layouts.app')
@section('title', 'Payment Success')
@section('content')

    <div class="container-fluid pt-5">
        <div class="row">
            <div class="col-lg-12">
                @if (session('message'))
                {{-- <h2 class="" style="text-align: center; width:100%; color:red"> {{ session('message') }}</h2> --}}
                @if (session('message'))
            <script>
                alert('{{ session('message') }}');
            </script>
        @endif
            @endif
                <a href="{{ route('client.home') }}" class="btn btn-primary">Quay lại trang chủ</a>
            </div>
        </div>
    </div>
@endsection