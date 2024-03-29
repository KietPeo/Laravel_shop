@extends('admin.layouts.app')
@section('title','Create Roles')
@section('content')
<div class="card">
    <h1>Create role</h1>
    <div>
        <form action="{{route('roles.store')}}" method="post">
            @csrf
            <div class="input-group input-group-dynamic mb-4">
                <label class="form-label">Name</label>
                <input type="text" value="{{old('name')}}" class="form-control" name="name">
                @error('name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="input-group input-group-dynamic mb-4">
                <label class="form-label">Display Name</label>
                <input type="text" class="form-control" value="{{old('display_name')}}" name="display_name">
                @error('display_name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="input-group input-group-static mb-4">
                <label for="group" class="ms-0">Group</label>
                <select class="form-control" id="group" name="group">
                    <option value="system">system</option>
                    <option value="user">user</option>
                </select>
                @error('group')
                <span class="text-danger">{{$message}}</span>
            @enderror
            </div>
          <div class="form-group">
            <label for="">Permission</label>
                <div class="row">
                    @foreach  ($permissions as $groupName => $permission)
                    <div class="col-5">
                        <h4>{{$groupName}}</h4>
                        <div>
                            @foreach ( $permission as $item)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permission_ids[]" value="{{$item->id}}"  >
                                <label class="custom-control-label" for="customCheck1">{{$item->display_name}}</label>
                              </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach 

                
                </div>
          </div>
        
           <button type="submit" class="btn btn-submit btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection