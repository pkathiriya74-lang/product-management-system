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
    <!-- ===================== HEADER ===================== -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="mb-0">Dashboard</h2>

        @if(Auth::user()->isAdmin())
            <div class="d-flex gap-2">
                <a href="/product_create" class="btn btn-success">
                    Create Product
                </a>

                <a href="/product_trash" class="btn btn-outline-primary">
                    Trash
                </a>

                <a href="/product_export" class="btn btn-outline-success">
                    Export CSV
                </a>
            </div>
        @endif

    </div>
    <!-- ===================== SEARCH & PRICE ===================== -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <!-- Search -->
                <div class="col-lg-6">
                    <form action="/product_search" method="GET">
                        <div class="input-group">
                            <input type="search" name="search" class="form-control" placeholder="Search product...">
                            <button class="btn btn-dark">
                                Search
                            </button>
                        </div>
                    </form>
                </div>
                <!-- Price -->
                <div class="col-lg-6">
                    <form action="/product_price_range" method="GET">
                        <div class="row g-2">
                            <div class="col">
                                <input type="number" name="first" class="form-control" placeholder="Min Price">
                            </div>
                            <div class="col">
                                <input type="number" name="second" class="form-control" placeholder="Max Price">
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-primary">
                                    Apply
                                </button>
                            </div>
                            <div class="col-auto">
                                <a href="/product" class="btn btn-secondary">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @if(Auth::user()->isAdmin())
        <!-- ===================== BULK ACTION ===================== -->
        <div class="card shadow-sm mb-3">
            <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                <form method="post" class="d-flex gap-2 align-items-center">
                    @csrf
                    <div class="d-flex justify-content-between align-items-center mb-3">
                            <label class="fw-semibold mb-0">Bulk Action</label>
                            <select name="action" class="form-select" style="width: 180px;">
                                <option value="">Choose Action</option>
                                <option value="active">Mark as Active</option>
                                <option value="inactive">Mark as Inactive</option>
                                <option value="draft">Mark as Draft</option>
                            </select>
                            <button type="submit" formaction="/product/bulk-action" class="btn btn-primary"> Apply</button>
                            <button type="submit" formaction="/product/bulk-action/delete" class="btn btn-danger"
                                onclick="return confirm('are you Sure you want to delete selected Product?')"> Delete </button>
                    </div>
               
            </div>
        </div>
    @endif
                <!-- ===================== STOCK + FILTERS ===================== -->
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                    @if(Auth::user()->isAdmin())
                        <div>
                            <span class="fw-semibold">
                                Current Stock:
                            </span>
                            <span class="badge bg-secondary ms-2 px-3 py-2">
                                {{ $stock }}
                            </span>
                        </div>
                    @endif
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="fw-semibold text-muted">
                            Filters:
                        </span>
                        <!-- Price -->
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                Price
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="/product_orderBy_price/asc">
                                        Ascending
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/product_orderBy_price/desc">
                                        Descending
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- Category -->
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                Category
                            </button>

                            <ul class="dropdown-menu">
                                @foreach($categories as $category)
                                    <li>
                                        <a class="dropdown-item" href="/product_filter_category/{{ $category->id }}">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @if(Auth::user()->isAdmin())
                            <!-- Status -->
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                    Status
                                </button>
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
                        @endif
                    </div>
                    @if(!Auth::user()->isAdmin())
                        <div>
                            <a href="/cart" class="btn btn-primary">Show Cart</a>
                        </div>
                    @endif
                </div>
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
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Category Name</th>


                                        @if(Auth::user()->isAdmin())
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                            <th>Duplicate</th>
                                            <th>Select</th>
                                        @endif
                                        @if(!Auth::user()->isAdmin())
                                            <th>Cart</th>
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
                                                        class="img-thumbnail preview-image" width="80" height="80"
                                                        alt="product_image">


                                                @else
                                                    <img src="{{ asset('storage/products/default.png') }}" class="img-thumbnail"
                                                        width="80" height="80" alt="product_image">
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
                                                <td>{{ $product->created_at->format('d M, Y, h:i A') }}</td>
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
                                            @if(!Auth::user()->isAdmin())
                                                <td>
                                                    <a href="/cart_addToCart/{{ $product->id }}" class="btn btn-sm btn-primary">Add
                                                        To Cart</a>
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