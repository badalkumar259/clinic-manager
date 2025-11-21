@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Add Product</h3>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" id="category" class="form-control" required>
                <option value="">Select Category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" 
                        {{ isset($product) && $product->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Subcategory</label>
            <select name="subcategory_id" id="subcategory" class="form-control" required></select>
        </div>

        <div class="mb-3">
            <label>Product Name</label>
            <input type="text" class="form-control" name="name" value="{{ $product->name ?? '' }}" required>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" class="form-control" name="price" step="0.01" value="{{ $product->price ?? '' }}" required>
        </div>

        <div class="mb-3">
            <label>Quantity</label>
            <input type="number" class="form-control" name="quantity" value="{{ $product->quantity ?? '' }}" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                @foreach(['Active','Inactive'] as $status)
                    <option value="{{ $status }}" 
                        @if(isset($product) && $product->status == $status) selected @endif>{{ $status }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>

    </form>
</div>
@endsection

@push('scripts')
<script>
$('#category').change(function(){
    let id = $(this).val();
    $('#subcategory').html('<option value="">Loading...</option>');
    $.get("{{ env('APP_URL') }}/get-subcategories/"+id, function(data){
        let options = '<option value="">Select Subcategory</option>';
        data.forEach(function(sub){
            options += `<option value="${sub.id}">${sub.name}</option>`;
        });
        $('#subcategory').html(options);
    });
});
</script>
@endpush