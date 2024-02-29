@extends('admin.layouts.app')
@section('title','Edit User'.$user->name)
@section('content')
<div class="card">
    <h1>Edit User</h1>
    <div>
        <form action="{{ route('users.update', $user->id) }}"  method="POST"enctype="multipart/form-data"  >
            @csrf
            @method('PUT')
        <div class="input-group input-group-static mb-4">
            <label >Name</label>
            <input type="text" value="{{old('name') ?? $user->name}}" class="form-control" name="name">
            @error('name')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="row">
            <div class=" input-group-static col-5 mb-4">
                <label >Image</label>
                <input type="file" accept="image/*" name="image" id="image-input" class="form-control">

                @error('image')
                    <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
            {{-- <div class="col-5">
                <img src="{{$user->images ? asset('upload/'.$user->images->first()->url) :'upload/default.jpg'}}" alt="" srcset="">
            
            </div> --}}
            <div class="col-5">
                <img src="{{ $user->images->first() ? asset('upload/' . $user->images->first()->url) : asset('upload/default.jpg') }}" alt="" srcset="">
            </div>
        </div>
        
        <div class="input-group input-group-static mb-4">
            <label  >Email</label>
            <input type="text" class="form-control" value="{{old('email') ?? $user->email}}" name="email">
            @error('email')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="input-group input-group-static mb-4">
            <label  >Password</label>
            <input type="password" class="form-control"  name="password">
            @error('password')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="input-group input-group-static mb-4">
            <label  >Phone Number</label>
            <input type="text" class="form-control" value="{{old('phone') ?? $user->phone }}" name="phone">
            @error('phone')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="input-group input-group-static mb-4">
            <label>Address</label>
            <textarea name="address" class="form-control">{{ old('address')?? $user->address }} </textarea>
            @error('address')
                <span class="text-danger"> {{ $message }}</span>
            @enderror
        </div>
        <div class="input-group input-group-static mb-4">
            <label for="group" name="group" class="ms-0">Gender</label>
            <select class="form-control" name="gender" value="{{$user->gender}}">
                <option value="male">male</option>
                <option value="female">female</option>
            </select>
            @error('gender')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
       
      <div class="form-group">
        <label for="">Roles</label>
            <div class="row">
                @foreach  ($roles as $groupName => $role)
                <div class="col-5">
                    <h4>{{$groupName}}</h4>
                    <div>
                        @foreach ( $role as $item)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="role_ids[]"{{$user->roles->contains('id',$item->id) ?'checked' :''}} value="{{$item->id}}"  >
                            <label class="custom-control-label" for="customCheck1">{{$item->display_name}}</label>
                          </div>
                        @endforeach
                    </div>
                </div>
            @endforeach 

            
            </div>
      </div>
      
      <button type="submit" class="btn btn-submit btn-primary" name="submit_button">update</button>
    </form>
</div>
</div>
<style>
#show-image {
display: none; /* Ẩn ô vuông mặc định */
}
</style>
@endsection


@yield('script')

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>
<script>
    $(() => {
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#show-image').attr('src', e.target.result);
                    $('#show-image').show(); // Hiển thị ô vuông khi có hình ảnh được chọn
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#image-input").change(function() {
            readURL(this);
        });



    });
</script>