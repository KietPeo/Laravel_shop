@extends('client2.layouts.index2')
@section('title', 'Settimg'.$user->name)
@section('content')

    @if (session('message'))
    {{-- <h2 class="" style="text-align: center; width:100%; color:red"> {{ session('message') }}</h2> --}}
    @if (session('message'))
        <script>
            alert('{{ session('message') }}');
        </script>
    @endif
@endif

    <form action="{{ route('profile.update', ['id' => $user->id]) }}" method="post">
    @csrf
    <div class="row ">
            <h1 class="text-center">Setting</h1>
        <div class="col-md-6 row d-flex justify-content-center mx-auto">
            <div class="col-md-4 text-center  border border-secondary-subtle rounded-4">
                <div class="mt-5">
                    <h5>Thông Tin</h5>
               
                <p>Tên: {{$user->name}}</p>
                <p>Email: {{$user->email}}</p>
                <p>Số Điện Thoại: {{$user->phone}}</p>
                <p>Địa Chỉ: {{$user->address}}</p>
                <p>Giới Tính: {{$user->gender}}</p>
                </div>
               
                
            </div>
            <div class="col-md-8 border border-secondary-subtle rounded-4 ">
                <div data-mdb-input-init class="form-outline mb-4 mt-3">
                    <input type="text" id="form4Example1" name="name" value="{{old('name') ?? $user->name}}" class="form-control" />
                    <label class="form-label" for="form4Example1" >Họ Tên</label>
                    @error('name')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                
                  <!-- Email input -->
                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="form4Example2" name="email" value="{{old('email') ?? $user->email}}" class="form-control" />
                    <label class="form-label" for="form4Example2" >Email </label>
                    @error('email')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="number" id="form4Example3" name="phone" value="{{old('phone') ?? $user->phone }}" class="form-control" />
                    <label class="form-label" for="form4Example3" >Số Điện Thoại</label>
                    @error('phone')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                  <!-- Message input -->
                  <div data-mdb-input-init class="form-outline mb-4">
                    <textarea class="form-control" id="form4Example4" name="address" value="{{old('address') ?? $user->address }}" rows="4"></textarea>
                    <label class="form-label" for="form4Example4">Địa Chỉ</label>
                    @error('address')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <label for="group" name="group" class="ms-0">Giới Tính</label>
                    
                    <select class="form-select" aria-label="Default select example" name="gender" value="{{old('gender') ?? $user->gender }}">
                        <option selected disabled>Chọn Giới Tính</option>
                        <option value="male" >male</option>
                        <option value="female">female</option>
                      </select>
                      @error('gender')
                      <span class="text-danger">{{$message}}</span>
                  @enderror
                  </div>
                 <div class="justify-content-end d-flex mb-3">
                    <button type="submit" class="btn btn-success">Thay Đổi</button>
                    {{-- <button type="submit" class="btn btn-submit btn-primary" name="submit_button">Submit</button> --}}
                </div>
                
                  
                    
            </div>
        </div>
    </div>
</form>  
<form id="changePasswordForm" action="{{ route('profile.update.password', ['id' => $user->id]) }}" class="mb-5" method="post">
    @csrf
    <div class="row mt-5">
        <div class="col-md-6 row d-flex justify-content-center mx-auto">
            <div class="col-md-4">
                <h5>Mật Khẩu</h5>
            </div>
            <div class="col-md-8 border border-secondary-subtle rounded-4 ">
                <!-- Nhập Mật Khẩu CŨ -->
                <div data-mdb-input-init class="form-outline mb-4 mt-3">
                    <input type="password" id="form4Example5" name="password" value="{{old('password') }}" class="form-control" />
                    <label class="form-label" for="form4Example5">Nhập Mật Khẩu CŨ</label>
                </div>
                <!-- Nhập Mật Khẩu Mới -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="form4Example6" name="newpassword" value="{{old('newpassword') }}" class="form-control" />
                    <label class="form-label" for="form4Example6">Nhập Mật Khẩu Mới</label>
                </div>
                <!-- Nhập Lại Mật Khẩu Mới -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="form4Example7" name="repassword" value="{{old('repassword') }}" class="form-control" />
                    <label class="form-label" for="form4Example7">Nhập Lại Mật Khẩu Mới</label>
                    <div id="passwordError" class="text-danger"></div>
                </div>
                <!-- Button -->
                <div class="justify-content-end d-flex mb-3">
                    <button type="submit" class="btn btn-success">Thay Đổi</button>
                </div>
            </div>
        </div>
    </div>
</form>
<style>
    #image-preview {
    width: 100px; /* Điều chỉnh kích thước theo mong muốn */
    height: auto; /* Đảm bảo tỷ lệ hình ảnh không bị biến dạng */
    display: block; /* Để hình ảnh hiển thị đúng dạng block */
}
</style>

<!-- JavaScript -->
<script>
    // Lắng nghe sự kiện submit của form
    document.getElementById("changePasswordForm").addEventListener("submit", function(event) {
        // Ngăn chặn hành động mặc định của form
        event.preventDefault();

        // Lấy giá trị của các trường nhập
        var newPassword = document.getElementById("form4Example6").value;
        var confirmPassword = document.getElementById("form4Example7").value;

        // Kiểm tra xem mật khẩu mới và nhập lại mật khẩu có khớp nhau không
        if (newPassword !== confirmPassword) {
            // Nếu không khớp, hiển thị thông báo lỗi và ngăn chặn việc submit form
            document.getElementById("passwordError").innerHTML = "Mật khẩu mới và mật khẩu nhập lại không khớp.";
            return;
        }else if (newPassword.length<8 || confirmPassword .length<8 ){
            document.getElementById("passwordError").innerHTML = "Mật khẩu mới hoặc mật khẩu nhập lại tối đa 8 kí tự.";
            return;
        }

        // Nếu mọi thứ hợp lệ, submit form
        this.submit();
    });
    document.getElementById("image-input").addEventListener("change", function(event) {
    // Lấy đối tượng hình ảnh và hiển thị nó ngay lập tức
    var imagePreview = document.getElementById("image-preview");
    imagePreview.src = URL.createObjectURL(event.target.files[0]);
});
</script>

<!-- Page He
@endsection