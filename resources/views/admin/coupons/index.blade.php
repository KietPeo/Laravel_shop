@extends('admin.layouts.app')
@section('title','Coupons')
@section('content')
    <div class="card">
        @if (session('message'))
        <div class="alert alert-info text-white text-center" role="alert">
            <h3>{{session('message')}}</h3>
        </div>
            
        @endif
        <h1>Coupons list</h1>
    <div class="">
        <a href="{{route('coupons.create')}}" class=" btn btn-primary">create</a>
    </div>
    <div class="">
        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Type</th>
                <th>Value</th>
                <th>Expery Date</th>
                <th>Action</th>
            </tr>
            @foreach ($coupons as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->tyoye}}</td>
                    <td>{{$item->value}}</td>
                    <td>{{$item->expery_date}}</td>
                    <td>
                        <a href="{{route('coupons.edit',$item->id)}}" type="button" class="btn bg-gradient-secondary">Edit</a>
                        <form action="{{route('coupons.destroy',$item->id)}}" method="post" id="form-delete{{$item->id}}">
                            @csrf
                            @method('delete')
                            <button  class="btn btn bg-gradient-danger"data-id={{$item->id}}>Delete</button>
                        </form>
                    </td>
                
                </tr>
            @endforeach
        </table>
        {{$coupons->links()}}
    </div>
</div>
@endsection