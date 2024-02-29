@extends('admin.layouts.app')
@section('title', 'Show Product')
@section('content')
    <div class="card">
        <h1>Show Product</h1>

        <div class="m-auto">
          
                @csrf
                <div class="row">
                    <div class="col-5">
                        <img src="{{$product->images ? asset('upload/'.$product->images->first()->url) :'upload/default.jpg'}}" alt="" srcset="">
                    
                    </div>
                </div>

                <div class="text-center">
                    <div class="form-group mb-4">
                        <span class="input-label">Name: {{$product->name}}</span>
                    </div>
                
                    <div class="form-group mb-4">
                        <span class="input-label">Price: {{$product->price}}</span>
                    </div>
                
                    <div class="form-group mb-4">
                        <span class="input-label">Sale: {{$product->sale}}</span>
                    </div>
                
                    <div class="form-group">
                        <label>Description : </label>
                        <div class="row w-100 h-100 d-flex justify-content-center">
                            {!! $product->description !!}
                        </div>
                    </div>
                
                    <input type="hidden" id="inputSize" name='sizes'>
                
                    <div class="form-group mb-4">
                        <span class="input-label" name="group">Category:</span>
                        @foreach ($product->categories as $item)
                            <p>{{$item->name}}</p>
                        @endforeach
                    </div>
                </div>
                
                
        </div>

        {{-- <button type="submit" class="btn btn-submit btn-primary">Submit</button> --}}

    </div>
    
        
    
        
      
        
@endsection

<script>
    
</script>