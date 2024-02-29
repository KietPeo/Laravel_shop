@extends('admin.layouts.app')
@section('title', 'Edit Product')
@section('content')
    <div class="card">
        <h1>Edit Product</h1>

        <div>
            <form action="{{ route('products.update',$product->id) }}" method="post" id="createForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class=" input-group-static col-5 mb-4">
                        <label >Image</label>
                        <input type="file" accept="image/*" name="image" id="image-input" class="form-control">
    
                        @error('image')
                            <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-5">
                        <img src="{{$product->images ? asset('upload/'.$product->images->first()->url) :'upload/default.jpg'}}" alt="" srcset="">
                    
                    </div>
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Name</label>
                    <input type="text" value="{{ old('name')?? $product->name }}" name="name" class="form-control">

                    @error('name')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Price</label>
                    <input type="number" step="0.1" value="{{ old('price') ?? $product->price }}" name="price" class="form-control">
                    @error('price')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Sale</label>
                    <input type="number" value="0" value="{{ old('sale')  ?? $product->sale }}" name="sale" class="form-control">
                    @error('sale')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
                <input type="hidden" name="sizes" id="sizesInput">
                <div class="row">
                    <div class="input-group input-group-static mb-4">
                        <label>Size :</label>
                        <div class="row size-row">
                            <div class="col-md-6">
                                <div class="ms-3">
                                    <label for="">Quantity</label>
                                    <input type="number" value="0" name="sizes[0][quantity]" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="ms-3">
                                    <label for="">Size</label>
                                           <input type="text" value="" name="sizes[0][size]" class="form-control">
                                </div>
                            </div>
                            
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <a href="#" class="btn btn-primary btn-lg active add-size-btn" role="button" aria-pressed="true">Thêm Size</a>
                        </div>
                    </div>
                </div>
                

                <div class="form-group">
                    <label>Description</label>
                    <div class="row w-100 h-100">
                        <textarea name="description" id="description" class="form-control" cols="4" rows="5"
                            style="width: 100%">{{ old('description')  ?? $product->description }} </textarea>
                    </div>
                    @error('description')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
                {{-- <input type="hidden" id="inputSize" name='sizes'>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddSizeModal">
                    Add size
                </button>

                <!-- Modal -->
                <div class="modal fade" id="AddSizeModal" tabindex="-1" aria-labelledby="AddSizeModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="AddSizeModalLabel">Add size</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body" id="AddSizeModalBody">

                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn  btn-primary btn-add-size">Add</button>
                            </div>
                        </div>
                    </div>
                </div> --}}
        </div>
        <div class="input-group input-group-static mb-4">
            <label name="group" class="ms-0">Category</label>
            <select name="category_ids[]" class="form-control" multiple>
                @foreach ($categories as $item)
                    <option value="{{ $item->id }}" {{$product->categories->contains('id',$item->id)? 'selected' :''}}>{{ $item->name }}</option>
                @endforeach
            </select>

            @error('category_ids')
                <span class="text-danger"> {{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-submit btn-primary">update</button>
        </form>
    </div>
    </div>
@endsection

@section('style')
    <style>
        .w-40 {
            width: 40%;
        }

        .w-20 {
            width: 20%;
        }

        .row {
            justify-content: center;
            align-items: center
        }

        .ck.ck-editor {
            width: 100%;
            height: 100%;
        }
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
        } else {
            $('#show-image').hide(); // Ẩn ô vuông nếu không có hình ảnh được chọn
        }
    }

    $("#image-input").change(function() {
        readURL(this);
    });

    // Gọi readURL() một lần nữa khi trang được tải lần đầu để ẩn ô vuông
    readURL(document.getElementById("image-input"));
});
$(document).ready(function() {
    $(".add-size-btn").click(function(e) {
        e.preventDefault(); // Ngăn chặn hành động mặc định của nút
        var sizeRows = $(".size-row"); // Lấy tất cả các hàng có class là 'size-row'
        var newRow = sizeRows.first().clone(); // Sao chép hàng đầu tiên
        // Tăng số lượng hàng đã có để tạo tên mới cho các input
        var newSizeIndex = sizeRows.length;
        // Đặt tên mới cho các input trong hàng mới
        newRow.find("input[name^='sizes']").each(function() {
            var newName = $(this).attr("name").replace(/\d+/, newSizeIndex);
            $(this).attr("name", newName);
        });
        newRow.find("input").val(""); // Xóa giá trị của input trong hàng mới
        sizeRows.last().after(newRow); // Thêm hàng mới vào cuối danh sách
    });
});
    </script>
