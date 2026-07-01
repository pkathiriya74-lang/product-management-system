@extends('layouts.app')

@section('title', 'products')

@section('content')
    <style>
        .preview-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .65);
            backdrop-filter: blur(8px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .preview-img {
            max-width: 650px;
            max-height: 650px;
            width: auto;
            height: auto;
            object-fit: contain;
            border-radius: 12px;
            background: white;
            padding: 10px;
            box-shadow: 0 0 30px rgba(0, 0, 0, .5);
        }
    </style>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Dashboard</h2>
        @if(Auth::user()->isAdmin())
            <a href="/product_create" class="btn btn-success">
                Create Product
            </a>

        @endif
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="/product_search" method="GET">
                @csrf
                <div class="row">
                    <div class="col-md-10">
                        <input type="search" name="search" class="form-control" placeholder="Search By Name...">
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-dark w-100">
                            Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <form action="/product_price_range" method="GET" class="row g-3 align-items-end">

                <div class="col-md-3">
                    <label class="form-label fw-bold">Price Range</label>
                    <input type="number" name="first" class="form-control" placeholder="Min Price"
                        value="{{ request('first') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <input type="number" name="second" class="form-control" placeholder="Max Price"
                        value="{{ request('second') }}">
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        Apply Filter
                    </button>
                </div>

                <div class="col-md-2">
                    <a href="/product" class="btn btn-secondary w-100">
                        Reset
                    </a>
                </div>

            </form>
        </div>
    </div>
    @if(Auth::user()->isAdmin())
        <div class="mb-3">
            <label class="form-label fw-bold">
                Current Product Stock:
                <span class="text-primary">{{ $stock }}</span>
            </label>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="/product_trash" class="btn btn-primary">
                Trash Products
            </a>
            <a href="/product_export" class="btn btn-success">Export CSV</a>
        </div>


        <form method="post">
            @csrf

            <div class="d-flex justify-content-between align-items-center mb-3">

                <div class="d-flex align-items-center gap-2">

                    <label class="fw-semibold mb-0">Bulk Action</label>

                    <select name="action" class="form-select" style="width: 180px;">
                        <option value="">Choose Action</option>
                        <option value="active">Mark as Active</option>
                        <option value="inactive">Mark as Inactive</option>
                        <option value="draft">Mark as Draft</option>
                        <option value="delete">Delete Selected</option>
                    </select>

                    <button type="submit" formaction="/product/bulk-action" class="btn btn-primary">
                        Apply
                    </button>

                </div>

                <small class="text-muted">
                    Select one or more products to perform a bulk action.
                </small>

            </div>
    @endif
        @if($products->isEmpty())
            <p>No product found </p>
        @endif
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Products Details</h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                @if(Auth::user()->isAdmin())
                                    <th> <input type="checkbox" id="checkAll"></th>
                                @endif
                                <th>Image</th>
                                <th>Name</th>
                                <th>SKU</th>
                                <th>
                                    <div class="dropdown">
                                        <a class="text-dark text-decoration-none dropdown-toggle" href="#" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Price
                                        </a>

                                        <ul class="dropdown-menu">

                                            <li>
                                                <a class="dropdown-item" href="/product_orderBy_price/asc">
                                                    Asecnding
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="/product_orderBy_price/desc">
                                                    Desecnding
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </th>
                                <th>Stock</th>
                                <th>
                                    <div class="dropdown">
                                        <a class="text-dark text-decoration-none dropdown-toggle" href="#" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Category Name
                                        </a>

                                        <ul class="dropdown-menu">
                                            @foreach($categories as $category)
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="/product_filter_category/{{ $category->id }}">
                                                        {{ $category->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </th>


                                @if(Auth::user()->isAdmin())
                                    <th>
                                        <div class="dropdown">
                                            <a class="text-dark text-decoration-none dropdown-toggle" href="" role="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Status
                                            </a>

                                            <ul class="dropdown-menu">

                                                <li>
                                                    <a class="dropdown-item" href="/product_orderBy_status/active">
                                                        Active
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="/product_orderBy_status/inactive">
                                                        Inactive
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="/product_orderBy_status/draft">
                                                        Draft
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                    <th>Duplicate</th>
                                    <th>Select</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    @if(Auth::user()->isAdmin())
                                        <td></td>
                                    @endif
                                    <td>

                                        @if($product->productImages->isNotEmpty())

                                            <img src="{{ asset('storage/' . $product->productImages->first()->image) }}"
                                                class="img-thumbnail preview-image" width="80" height="80" alt="product_image">


                                        @else
                                            <img src="{{ asset('storage/products/default.png') }}" class="img-thumbnail" width="80"
                                                height="80" alt="product_image">
                                        @endif

                                    </td>
                                    <td><a href="/product/{{ $product->id }}">{{ $product->name }}</a></td>
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



                                    @if(Auth::user()->isAdmin())
                                        <td>{{ $product->status }}</td>
                                        <td>{{ $product->created_at }}</td>
                                        <td>
                                            <a href="/product_edit/{{ $product->id }}" class="btn btn-sm btn-warning">
                                                Edit
                                            </a>

                                            <a href="/product_delete/{{ $product->id }}" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Delete this Product?')">
                                                Delete
                                            </a>
                                        </td>
                                        <td>
                                            <a href="/product_duplicate/{{ $product->id }}" class="btn btn-sm btn-primary">
                                                Duplicate
                                            </a>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="products[]" value="{{ $product->id }}"
                                                class="product-check">
                                        </td>
                                    @endif

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="imagePreviewOverlay" class="preview-overlay">

                <img id="previewImage" src="" class="preview-img">

            </div>

        </div>
    </form>
    <div clasa="d-flex justify-content-center mt-3">
        @if(!$products->isEmpty())
            {{ $products->links() }}
        @endif
    </div>
    <script>
        const overlay = document.getElementById('imagePreviewOverlay');
        const preview = document.getElementById('previewImage');

        document.querySelectorAll('.preview-image').forEach(image => {

            image.addEventListener('mouseenter', function () {

                preview.src = this.src;
                overlay.style.display = 'flex';

            });

            image.addEventListener('mouseleave', function () {

                overlay.style.display = 'none';

            });

        });

        document.getElementById('checkAll').addEventListener('change', function () {
            const checked = this.checked;

            document.querySelectorAll('.product-check').forEach(function (checkbox) {
                checkbox.checked = checked;
            });
        });
    </script>
@endsection