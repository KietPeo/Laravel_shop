@extends('admin.layouts.app')
@section('title','Products')
@section('content')
    <div class="card">
        @if (session('message'))
        <div class="alert alert-info text-white text-center" role="alert">
            <h3>{{session('message')}}</h3>
        </div>
            
        @endif
        <h1>Product list</h1>
    <div class="">
        <a href="{{route('products.create')}}" class=" btn btn-primary">create</a>
    </div>
    <div class="">
        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>image</th>
                <th>Sale</th>
                <th>Price</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            @foreach ($products as $item)
                <tr>
                    
                    <td>{{$item->id}}</td>
                    <td>{{$item->name}}</td>
                    <td><img src="{{$item->images->count()>0 ? asset('upload/'.$item->images->first()->url) : 'upload/default.jpg'}}" width="50px" height="50px" srcset=""></td>
                    <td>{{$item->sale}}</td>
                    <td>{{$item->price}}</td>
                    <td>{{$item->description}}</td>
                    <td>
                        <a href="{{route('products.edit',$item->id)}}" type="button" class="btn bg-gradient-secondary">Edit</a>
                        <a href="{{route('products.show',$item->id)}}" type="button" class="btn bg-gradient-info">Show</a>
                        <form action="{{route('products.destroy',$item->id)}}" method="post" id="form-delete{{$item->id}}">
                            @csrf
                            @method('delete')
                            <button  class="btn btn bg-gradient-danger"data-id={{$item->id}}>Delete</button>
                        </form>
                    </td>
                
                </tr>
            @endforeach
        </table>
        {{$products->links()}}
    </div>
</div>
@endsection