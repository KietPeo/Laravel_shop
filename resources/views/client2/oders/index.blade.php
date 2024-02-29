  <!-- Featured Start -->
  @extends('client2.layouts.index')
  @section('title', 'Cart')
  @section('content')


      <div class="row px-xl-5">
        <div class="container-fluid pt-5">
            <div class="row text-center">
                <div class="col-lg-12">
                    @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                    @endif
                   
                </div>
            </div>
        </div>
         
          <div class="col-lg-8 table-responsive mb-5 m-auto ">
              <table class=" table table-hover  table-bordered ">
                  <thead class=" text-dark">
                      <tr>
                          <th>#</th>
                          <th>Trạng Thái</th>
                          <th>Tổng Tiền</th>
                          <th>Phí Vận Chuyển</th>
                          <th>Tên Người Đặt</th>
                          <th>Email</th>
                          <th>Số Điện Thoại</th>
                          <th>Địa Chỉ</th>
                          <th>Ghi Chú</th>
                          <th>Phương Thức</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody class="align-middle">
                      @foreach ($orders as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->status}}</td>
                                <td>{{$item->total}}</td>
                                <td>{{$item->ship}}</td>
                                <td>{{$item->customer_name}}</td>
                                <td>{{$item->customer_email}}</td>
                                <td>{{$item->customer_phone}}</td>
                                <td>{{$item->customer_address}}</td>
                                <td>{{$item->note}}</td>
                                <td>{{$item->payment}}</td>
                                <td>
                                    @if ($item->status==='pending')
                                        
                                   <form action="{{route('client2.orders.cancel',$item->id)}}" id="form-cancel{{$item->id}}" method="post">
                                    @csrf
                                        <button class="btn btn-cancel btn-danger" data-id="{{$item->id}}">Cancel Order</button>
                                   </form>
                                    @endif
                                    
                                </td>
                            </tr>
                      @endforeach

                  </tbody>
              </table>
                    {{$orders->links()}}
          </div>
         <div class="text-center">
            <a href="{{ route('client2.home') }}" class="btn btn-primary">Quay lại trang chủ</a>
         </div>
      </div>
  @endsection

  @section('script')
  <script>

$(function(){
    $(document).on('click', '.btn-cancel', function(e){
        e.preventDefault();
        const button = $(this); // Save reference to the button
        confirmDelete()
            .then(function(){
                const id = button.data('id'); // Get the data-id attribute value from the button
                $(`#form-cancel${id}`).submit(); // Submit the form with the corresponding ID
            })
            .catch(function() {
                console.log('Cancelled action'); // Handle cancellation
            });
    });
});
</script>

  @endsection
 