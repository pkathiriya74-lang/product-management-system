@extends('layouts.app')

@section('title', 'products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Trash Products</h2>
</div>
@if($products->isEmpty())
    <p>No product found </p>
@endif
<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Products</h5>
    </div>

    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Deleted At</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>
                         @if($product->productImages->isNotEmpty())

                                <img src="{{ asset('storage/' . $product->productImages->first()->image) }}"
                                    class="img-thumbnail preview-image" width="80" height="80" alt="product_image">


                            @else
                                <img src="{{ asset('storage/products/default.png') }}" class="img-thumbnail" width="80"
                                    height="80" alt="product_image">
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->sku }}</td>
                        <td>${{ $product->price }}.00</td>
                        @if($product->stock <= 5)
                            <td>
                                <span class="fs-8 fw-bold text-danger">
                                    {{ $product->stock}}
                                </span>
                                <span class="badge bg-danger">Low Stock</span>
                            </td>
                        @else
                            <td>{{ $product->stock }}</td>
                        @endif
                        <td>{{ $product->category->name }}</td>
                            <td>{{ $product->status }}</td>
                            <td>{{ $product->created_at }}</td>
                            <td>{{ $product->deleted_at }}</td>
                            <td>
                                <a href="/product_restore/{{ $product->id }}" class="btn btn-sm btn-success">
                                    Restore
                                </a>

                                <a href="/product_forceDelete/{{ $product->id }}" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this Product permanently ?')">
                                    Delete Permanently 
                                </a>
                            </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endsection