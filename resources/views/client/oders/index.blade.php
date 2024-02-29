  <!-- Featured Start -->
  @extends('client.layouts.app')
  @section('title', 'Cart')
  @section('content')


      <div class="row px-xl-5">
          @if (session('message'))
              <div class="row">
                  <h3 class="text-danger">{{ session('message') }}</h3>
              </div>
          @endif
          <div class="col-lg-8 table-responsive mb-5 m-auto ">
              <table class=" table table-hover  table-bordered ">
                  <thead class=" text-dark">
                      <tr>
                          <th>#</th>
                          <th>Status</th>
                          <th>Total</th>
                          <th>Ship</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Address</th>
                          <th>note</th>
                          <th>payment</th>
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
                                        
                                   <form action="{{route('client.orders.cancel',$item->id)}}" id="form-cancel{{$item->id}}" method="post">
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
 