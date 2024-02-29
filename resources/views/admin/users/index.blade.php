@extends('admin.layouts.app')
@section('title','Users')
@section('content')
    <div class="card">
        @if (session('message'))
        <div class="alert alert-info text-white text-center" role="alert">
            <h3>{{session('message')}}</h3>
        </div>
            
        @endif
        <h1>Users list</h1>
    <div class="">
        <a href="{{route('users.create')}}" class=" btn btn-primary">create</a>
    </div>
    <div class="">
        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Password</th>
                <th>Adress</th>
                <th>Gender</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
            @foreach ($users as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->email}}</td>
                    <td>{{$item->phone}}</td>
                    <td>{{$item->password}}</td>
                    <td>{{$item->address}}</td>
                    <td>{{$item->gender}}</td>
                    {{-- <td><img src="{{$item->images->count()>0 ? asset('upload/'.$item->images->first()->url) : 'upload/default.jpg'}}" width="50px" height="50px" srcset=""></td>
                     --}}
                     <td>
                        @if($item->images->count() > 0)
                            <img src="{{ asset('upload/' . $item->images->first()->url) }}" width="50px" height="50px" alt="User Image">
                        @else
                            <img src="{{ asset('upload/default.jpg') }}" width="50px" height="50px" alt="Default Image">
                        @endif
                    </td>
                    <td>
                        <a href="{{route('users.edit',$item->id)}}" type="button" class="btn bg-gradient-secondary">Edit</a>
                        <form action="{{route('users.destroy',$item->id)}}" method="post" id="form-delete{{$item->id}}">
                            @csrf
                            @method('delete')
                            <button  class="btn btn bg-gradient-danger" type="submit" data-id={{$item->id}}>Delete</button>
                        </form>
                    </td>
                
                </tr>
            @endforeach
        </table>
       <div class="text-center">
        {{$users->links()}}
       </div>
    </div>
</div>
@endsection