@extends('layouts.app')

@section('title', 'Cart')

@section('content')

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold"> My Cart</h2>
            
           <a href="/product" class="btn btn-secondary">Back To products</a>
        </div>
        @php
            $grandTotal = 0;
        @endphp
        @if($carts->count())
            <div class="card shadow-sm">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>No.</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th width="120">Quantity</th>
                                <th>Total</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($carts as $index => $cart)
                                @php
                                    $total = $cart->product->price * $cart->quantity;
                                    $grandTotal += $total;
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/' . $cart->product->productImages->first()->image) }}"
                                                class="rounded border me-3" width="80" height="80" style="object-fit:cover;">
                                            <div>
                                                <h6 class="mb-1">
                                                    {{ $cart->product->name }}
                                                </h6>
                                                <small class="text-muted">
                                                    SKU :
                                                    {{ $cart->product->sku }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        ${{ number_format($cart->product->price, 2) }}
                                    </td>
                                    <td>
                                        <div class="d-inline-flex align-items-center border rounded overflow-hidden">

                                            <a href="{{ $cart->quantity > 1 ? '/cart_update/' . $cart->id . '/dec' : '#' }}"
                                                class="btn btn-light border-0 px-3 {{ $cart->quantity <= 1 ? 'disabled' : '' }}">
                                                -
                                            </a>

                                            <span class="px-3 fw-bold">
                                                {{ $cart->quantity }}
                                            </span>

                                            <a href="{{ $cart->quantity <= $cart->product->stock ? '/cart_update/' . $cart->id . '/inc' : '#' }}"
                                                class="btn btn-light border-0 px-3 {{ $cart->quantity >= $cart->product->stock ? 'disabled' : '' }}">
                                                +
                                            </a>

                                        </div>
                                    </td>
                                    <td>
                                        <strong>
                                            ${{ number_format($total, 2) }}
                                        </strong>
                                    </td>
                                    <td>
                                        <a href="/cart_remove/{{ $cart->id }}" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Remove this item?')">
                                            Remove
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card shadow-sm mt-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        Grand Total
                    </h4>
                    <h3 class="text-success mb-0">
                        ${{ number_format($grandTotal, 2) }}
                    </h3>
                </div>
            </div>
        @else
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <h3>Your cart is empty.</h3>
                    <p class="text-muted">
                        Start shopping and add products to your cart.
                    </p>
                    <a href="/product" class="btn btn-primary">
                        Continue Shopping
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection