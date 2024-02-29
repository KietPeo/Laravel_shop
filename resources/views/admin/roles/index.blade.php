@extends('admin.layouts.app')
@section('title','Roles')
@section('content')
    <div class="card">
        @if (session('message'))
        <div class="alert alert-info text-white text-center" role="alert">
            <h3>{{session('message')}}</h3>
        </div>
            
        @endif
        <h1>Role list</h1>
    <div class="">
        <a href="{{route('roles.create')}}" class=" btn btn-primary">create</a>
    </div>
    <div class="">
        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>DisplayName</th>
                <th>Action</th>
            </tr>
            @foreach ($roles as $role)
                <tr>
                    <td>{{$role->id}}</td>
                    <td>{{$role->name}}</td>
                    <td>{{$role->display_name}}</td>
                    <td>
                        <a href="{{route('roles.edit',$role->id)}}" type="button" class="btn bg-gradient-secondary">Edit</a>
                        <form action="{{route('roles.destroy',$role->id)}}" method="post" id="form-delete{{$role->id}}">
                            @csrf
                            @method('delete')
                            <button  class="btn  btn-delete bg-gradient-danger"data-id={{$role->id}}>Delete</button>
                        </form>
                    </td>
                
                </tr>
            @endforeach
        </table>
        {{$roles->links()}}
    </div>
</div>
@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.js" crossorigin="anonymous" integrity="sha384-MR7WxXGfnP0ikNUd+3mzoaI2Fv38f5cLY4B4P+6QsbfFwt0Qyp8AMGLgFET4ivWp"></script>
{{-- Vào SweetAlert2 để lấy CDN từ trang web chính thức --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(function() {
        function confirmDelete() {
            return new Promise((resolve, reject) => {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        resolve(true);
                    } else {
                        reject(false);
                    }
                });
            });
        }

        $(document).on('click', '.btn-delete', function(e) {
            
          e.preventDefault();
          let id = $(this).data('id');
          confirmDelete().then(function() {
            $(`#form-delete${id}`).submit()
          })
        });
    });

</script>
@endsection
