@extends('layouts.app')

@section('title', 'Create product')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow">
                <div class="card-header text-center">
                    <h3>Edit product</h3>
                </div>

                <div class="card-body">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="/product_edit/{{ $product->id }}" method="POST" enctype="multipart/form-data"
                        id="productForm">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">name</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name', $product->name) }}" placeholder="Enter name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" name="price" id="price" class="form-control"
                                value="{{ old('price', $product->price) }}" placeholder="Enter Price">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" id="stock" class="form-control"
                                value="{{ old('stock', $product->stock) }}" placeholder="Enter Stock">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>

                            <select name="category_id" id="category_id" class="form-select">
                                <option value="">Select Category</option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id || $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>

                            <select name="status" id="status" class="form-select">
                                <option value="">Select Status</option>
                                <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                                <option value="draft" {{ $product->status == 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image [You Can Upload {{ $remainingImages }}.]</label>
                            <input type="file" name="images[]" id="image" class="form-control" multiple>
                        </div>


                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Update Product
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

    <script>
        document.getElementById('productForm').addEventListener('submit', function (e) {

            let price = document.getElementById('price').value.trim();
            let stock = document.getElementById('stock').value.trim();

            if (price <= 0) {
                alert('Price must be greater than 0.');
                e.preventDefault();
                return;
            }
            if (stock < 0) {
                alert('Stock must be postive');
                e.preventDefault();
                return;
            }
            document.getElementById('loader').style.display = 'flex';

        });
    </script>
@endsection