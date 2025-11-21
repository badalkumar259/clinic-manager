@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Products</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">+ Add Product</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table id="products-table" class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th><th>Category</th><th>Subcategory</th>
                <th>Price</th><th>Quantity</th><th>Status</th><th>Action</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#products-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('products.data') }}',
        columns: [
            { data: 'name' },
            { data: 'category' },
            { data: 'subcategory' },
            { data: 'price' },
            { data: 'quantity' },
            { data: 'status' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
@endpush