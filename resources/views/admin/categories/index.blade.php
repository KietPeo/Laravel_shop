@extends('admin.layouts.app')
@section('title','Category')
@section('content')
    <div class="card">
        @if (session('message'))
        <div class="alert alert-info text-white text-center" role="alert">
            <h3>{{session('message')}}</h3>
        </div>
            
        @endif
        <h1>Category list</h1>
    <div class="">
        <a href="{{route('categories.create')}}" class=" btn btn-primary">create</a>
    </div>
    <div class="">
        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Parent Name</th>
                <th>Action</th>
            </tr>
            @foreach ($categories as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->parent_name}}</td>
                    <td>
                        <a href="{{route('categories.edit',$item->id)}}" type="button" class="btn bg-gradient-secondary">Edit</a>
                        <form action="{{route('categories.destroy',$item->id)}}" method="post" id="form-delete{{$item->id}}">
                            @csrf
                            @method('delete')
                            <button  class="btn btn bg-gradient-danger"data-id={{$item->id}}>Delete</button>
                        </form>
                    </td>
                
                </tr>
            @endforeach
        </table>
        {{$categories->links()}}
    </div>
</div>
@endsection