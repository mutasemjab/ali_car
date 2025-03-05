@extends('layouts.admin')
@section('title')
{{ __('messages.Edit') }} {{ __('messages.purchaseOrders') }}
@endsection



@section('contentheaderlink')
<a href="{{ route('purchaseOrders.index') }}"> {{ __('messages.purchaseOrders') }} </a>
@endsection

@section('contentheaderactive')
{{ __('messages.Edit') }}
@endsection

@section('content')
<div class="container">
    <h2>Edit Purchase Order</h2>

    <form action="{{ route('purchaseOrders.update', $purchaseOrder->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="date_of_receive" class="form-label">Date of Receive</label>
            <input type="date" name="date_of_receive" id="date_of_receive" class="form-control" value="{{ $purchaseOrder->date_of_receive }}" required>
        </div>

        <div class="mb-3">
            <label for="note" class="form-label">Note</label>
            <textarea name="note" id="note" class="form-control">{{ $purchaseOrder->note }}</textarea>
        </div>

        <h4>Products</h4>
        <div id="products">
            @foreach($purchaseOrder->items as $index => $item)
                <div class="product-item">
                    <div class="mb-2">
                        <label>Name</label>
                        <input type="text" name="items[{{ $index }}][name]" class="form-control" value="{{ $item->name }}" required>
                    </div>
                    <div class="mb-2">
                        <label>Quantity</label>
                        <input type="number" name="items[{{ $index }}][quantity]" class="form-control" value="{{ $item->quantity }}" required>
                    </div>
                    <div class="mb-2">
                        <label>Note</label>
                        <input type="text" name="items[{{ $index }}][note]" class="form-control" value="{{ $item->note }}">
                    </div>
                    <button type="button" class="btn btn-danger remove-product">Remove</button>
                </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-primary" id="add-product">Add Product</button>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>

@endsection

@section('script')

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let productIndex = {{ count($purchaseOrder->items) }};
    
        document.getElementById("add-product").addEventListener("click", function() {
            let newProduct = `
                <div class="product-item">
                    <div class="mb-2">
                        <label>Name</label>
                        <input type="text" name="items[${productIndex}][name]" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Quantity</label>
                        <input type="number" name="items[${productIndex}][quantity]" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Note</label>
                        <input type="text" name="items[${productIndex}][note]" class="form-control">
                    </div>
                    <button type="button" class="btn btn-danger remove-product">Remove</button>
                </div>
            `;
            document.getElementById("products").insertAdjacentHTML("beforeend", newProduct);
            productIndex++;
        });
    
        document.getElementById("products").addEventListener("click", function(e) {
            if (e.target.classList.contains("remove-product")) {
                e.target.parentElement.remove();
            }
        });
    });
    </script>
@endsection
