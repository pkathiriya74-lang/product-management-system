@extends('layouts.app')

@section('title', 'Create product')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow">
                <div class="card-header text-center">
                    <h3>Create New product</h3>
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

                    <form action="/product_create" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                                placeholder="Enter name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}"
                                placeholder="Enter Price">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock') }}"
                                placeholder="Enter Stock">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>

                            <select name="category_id" id="category_id" class="form-select">
                                <option value="">Select Category</option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>

                            <select name="status" id="status" class="form-select">
                                <option value="">Select Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                        <div id="previewContainer" class="mt-3 d-flex flex-wrap gap-2" style="display: flex; gap: 10px; flex-wrap: wrap;"></div>
                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="images[]" id="imageInput" accept="image/*" class="form-control" multiple>
                        </div>


                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Add Product
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>


<script>
    document.getElementById('productForm').addEventListener('submit',function(e){

        let price = document.getElementById('price').value.trim();
        let stock = document.getElementById('stock').value.trim();

        if(price <= 0){
            alert('Price must be greater than 0.');
            e.preventDefault();
            return;
        }
        if(stock < 0){
            alert('Stock must be postive');
            e.preventDefault();
            return;
        }
         document.getElementById('loader').style.display = 'flex';

    });

    document.getElementById('imageInput').addEventListener('change', function(event) {
        const files = event.target.files;
        const previewContainer = document.getElementById('previewContainer');
        
        previewContainer.innerHTML = '';

        if (files.length > 0) {
            // Convert file list to an array and loop through each file
            Array.from(files).forEach(file => {
                // Ensure the file is actually an image type
                if (file.type.startsWith('image/')) {
                    const img = document.createElement('img');
                    
                    // Generate temporary DOM URL for this specific file
                    img.src = URL.createObjectURL(file);
                    
                    // Apply visual styling directly
                    img.style.maxWidth = '80px';
                    img.style.maxHeight = '80px';
                    img.style.borderRadius = '8px';
                    img.style.objectFit = 'cover';
                    img.style.border = '1px solid #ccc';
                    img.alt = 'Selected Image Preview';

                    // Append the new image element to our preview gallery container
                    previewContainer.appendChild(img);
                }
            });
        }
    });
</script>
@endsection