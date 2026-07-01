@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="container">

        <h2 class="mb-4">Dashboard</h2>

        <div class="row">

            <div class="col-md-6 mb-4">
                <div class="card shadow border-0">
                    <div class="card-body text-center">
                        <h4 class="card-title">Category Management</h4>
                        <p class="text-muted">
                            View, create, edit and manage product categories.
                        </p>

                        <a href="/category" class="btn btn-primary">
                            View Categories
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card shadow border-0">
                    <div class="card-body text-center">
                        <h4 class="card-title">Product Management</h4>
                        <p class="text-muted">
                            View, create, edit and manage products.
                        </p>

                        <a href="/product" class="btn btn-success">
                            View Products
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <div class="container">

    <h2 class="mb-4">Dashboard Statistics</h2>

    <div class="row">

        <div class="col-md-3 mb-3">
            <div class="card text-center shadow border-0">
                <div class="card-body">
                    <h5>Total Categories</h5>
                    <h2 class="text-primary">{{ $totalCategory }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-center shadow border-0">
                <div class="card-body">
                    <h5>Total Products</h5>
                    <h2 class="text-success">{{ $totalProduct }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-center shadow border-0">
                <div class="card-body">
                    <h5>Total Stock</h5>
                    <h2 class="text-info">{{ $totalStock }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-center shadow border-0">
                <div class="card-body">
                    <h5>Low Stock [Less Than 5]</h5>
                    <h2 class="text-danger">{{ $lowStockProducts }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-center shadow border-0">
                <div class="card-body">
                    <h5>Out Of Stock</h5>
                    <h2 class="text-danger">{{ $outOffStockProduct }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-center shadow border-0">
                <div class="card-body">
                    <h5>Active Products</h5>
                    <h2 class="text-success">{{ $activeProducts }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-center shadow border-0">
                <div class="card-body">
                    <h5>Total Inventory</h5>
                    <h2 class="text-info">${{number_format($totalInventory ,2)}}</h2>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection