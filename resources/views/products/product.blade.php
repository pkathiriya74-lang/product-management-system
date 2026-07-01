@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
    <style>
        .thumb-wrapper {
            position: relative;
            width: 80px;
            height: 80px;
        }

        .delete-btn {
            position: absolute;
            top: 5px;
            right: 5px;

            width: 22px;
            height: 22px;

            background: rgba(220, 53, 69, .9);
            color: white;

            border-radius: 50%;

            display: flex;
            justify-content: center;
            align-items: center;

            text-decoration: none;
            font-size: 11px;

            opacity: 0;
            transition: .25s;
        }

        .thumb-wrapper:hover .delete-btn {
            opacity: 1;
        }

        .delete-btn:hover {
            background: #dc3545;
            color: white;
            transform: scale(1.1);
        }
    </style>
    <div class="container py-4">

        <div class="card shadow border-0">

            <div class="card-body">

                <div class="row">
                    <div class="col-md-5 text-center">

                        @if($product->productImages->isNotEmpty())

                            <img src="{{ asset('storage/' . $product->productImages->first()->image) }}"
                                class="img-fluid rounded shadow mb-3" style="height:350px; object-fit:contain;">

                        @else

                            <img src="{{ asset('storage/products/default.png') }}" class="img-fluid rounded shadow mb-3"
                                style="height:350px; object-fit:contain;">

                        @endif

                        <div class="d-flex justify-content-center flex-wrap gap-2">

                            @foreach($product->productImages as $image)

                                <div class="thumb-wrapper position-relative">

                                    <img src="{{ asset('storage/' . $image->image) }}" width="80" height="80"
                                        class="rounded border preview-image" style="object-fit:cover;">

                                    <a href="/product/image/delete/{{ $image->id }}" class="delete-btn"
                                        onclick="return confirm('Delete this image?')">

                                        <i class="bi bi-trash-fill"></i>

                                    </a>

                                </div>

                            @endforeach

                        </div>

                    </div>

                    <div class="col-md-7">

                        <h2 class="fw-bold">{{ $product->name }}</h2>

                        <hr>

                        <table class="table table-bordered align-middle">

                            <tr>
                                <th width="180">SKU</th>
                                <td>{{ $product->sku }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><span class="badge bg-success">{{ $product->status }}</span></td>
                            </tr>

                            <tr>
                                <th>Price</th>
                                <td>
                                    <span class="fs-4 fw-bold text-success">
                                        $ {{ number_format($product->price, 2) }}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <th>Stock</th>
                                <td>

                                    @if($product->stock > 10)

                                        <span class="badge bg-success">
                                            {{ $product->stock }} Available
                                        </span>

                                    @elseif($product->stock > 0)

                                        <span class="badge bg-warning text-dark">
                                            Only {{ $product->stock }} Left
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            Out of Stock
                                        </span>

                                    @endif

                                </td>
                            </tr>

                            <tr>
                                <th>Category</th>
                                <td>{{ $product->category->name }}</td>
                            </tr>

                            <tr>
                                <th>Created At</th>
                                <td>{{ $product->created_at->format('d M, Y, h:i A') }}</td>
                            </tr>

                        </table>

                        <div class="mt-4">

                            <a href="/product" class="btn btn-secondary">
                                ← Back to Products
                            </a>
                            @if(Auth::user()->isAdmin())
                                <a href="/product_edit/{{ $product->id }}" class="btn btn-primary">
                                    Edit Product
                                </a>
                            @endif
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection