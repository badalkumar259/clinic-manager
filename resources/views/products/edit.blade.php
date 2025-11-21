@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Product</h3>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('products.update',$product->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Category</label>
            <select name="category" id="category" class="form-control" required>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ $product->category == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Subcategory</label>
            <select name="subcategory" id="subcategory" class="form-control" required>
            </select>
        </div>

        <div class="mb-3">
            <label>Product Name</label>
            <input type="text" name="name" value="{{ $product->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Quantity</label>
            <input type="number" name="quantity" value="{{ $product->quantity }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="1" {{ $product->status==1?'selected':'' }}>Active</option>
                <option value="0" {{ $product->status==0?'selected':'' }}>Inactive</option>
            </select>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

@push('scripts')
<script>
function loadSubcategories(categoryId, selectedId = null){
    $.get("{{ env('APP_URL') }}/get-subcategories/"+categoryId, function(data){
        let options = '<option value="">Select Subcategory</option>';
        data.forEach(function(sub){
            options += `<option value="${sub.id}" ${selectedId == sub.id ? 'selected':''}>${sub.name}</option>`;
        });
        $('#subcategory').html(options);
    });
}

loadSubcategories($('#category').val(), "{{ $product->subcategory }}");

$('#category').change(function(){
    loadSubcategories($(this).val());
});
</script>
@endpush