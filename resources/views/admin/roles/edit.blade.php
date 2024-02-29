@extends('admin.layouts.app')
@section('title','Edit Roles'.$role->name)
@section('content')
<div class="card">
    <h1>Edit role</h1>
    <div>
        <form action="{{route('roles.update',$role->id)}}" method="post">
            @csrf
            @method('PUT')
            <div class="input-group input-group-dynamic mb-4">
                <label class="form-label">Name</label>
                {{-- value="{{old('name')?? $role->name}}" value se khong phai la old name nua ma de ??  neu co gia
                tri submit thi lay ra con khong thi mac dinh --}}
                <input type="text" value="{{old('name') ?? $role->name}}" class="form-control" name="name">
                @error('name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="input-group input-group-dynamic mb-4">
                <label class="form-label">Display Name</label>
                 {{-- value="{{old('display_name') ?? $role->display_name}}" value se khong phai la old display_name nua ma de ??  neu co gia
                tri submit thi lay ra con khong thi mac dinh --}}
                <input type="text" class="form-control" value="{{old('display_name') ?? $role->display_name}}" name="display_name">
                @error('display_name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="input-group input-group-static mb-4">
                <label for="group" class="ms-0">Group</label>
                <select class="form-control" id="group" name="group" value="{{$role->group}}">
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
                                <input class="form-check-input" type="checkbox" name="permission_ids[]" value="{{$item->id}}" >
                                {{-- o day permission la quan he cua no --}}
                                {{$role->permissions->contains('name',$item->name)?'checked':''}}   {{-- neu no co giong nhau thi check no con khong thi khong co gi --}}
                                <label class="custom-control-label" for="customCheck1">{{$item->display_name}}</label>
                              </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach 

                
                </div>
          </div>
        
           <button type="submit" class="btn btn-submit btn-primary">update</button>
        </form>
    </div>
</div>
@endsection