@extends('admin.layouts.app')
@section('title', 'Create Coupons')
@section('content')
<div class="card">
    <h1>Create Coupons</h1>
    <div>
        <form action="{{ route('coupons.store') }}" method="post">
            @csrf
            <div class="input-group input-group-dynamic mb-4">
                <label class="form-label">Name</label>
                <input type="text" value="{{ old('name') }}" class="form-control text-uppercase" name="name">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-group input-group-dynamic mb-4">
                <label class="form-label">Value</label>
                <input type="number" value="{{ old('value') }}" class="form-control" name="value">
                @error('value')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-group input-group-dynamic mb-4">
                <label class="form-label">Expiry</label>
                <input type="date" value="{{ old('expiry_date') }}" class="form-control" name="expiry_date">
                @error('expiry_date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-group input-group-static mb-4">
                <label for="group" class="ms-0">Type</label>
                <select class="form-control" id="parent" name="type">
                    <option value="">Select Type</option>
                    <option value="money">Money</option>
                </select>
                @error('type')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
           <button type="submit" class="btn btn-submit btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection