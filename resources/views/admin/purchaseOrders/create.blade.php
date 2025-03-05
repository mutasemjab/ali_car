@extends('layouts.admin')
@section('title')
{{ __('messages.purchaseOrders') }}
@endsection



@section('content')
<div class="container">
    <h2>Create Purchase Order</h2>

    <form action="{{ route('purchaseOrders.store') }}" method="post" enctype='multipart/form-data'>
        @csrf
        <div class="mb-3">
            <label for="date_of_receive" class="form-label">Date of Receive</label>
            <input type="date" name="date_of_receive" id="date_of_receive" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="note" class="form-label">Note</label>
            <textarea name="note" id="note" class="form-control"></textarea>
        </div>

        <h4>Products</h4>
        <div id="products">
            <div class="product-item">
                <div class="mb-2">
                    <label>Name</label>
                    <input type="text" name="items[0][name]" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Quantity</label>
                    <input type="number" name="items[0][quantity]" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Note</label>
                    <input type="text" name="items[0][note]" class="form-control">
                </div>
                <button type="button" class="btn btn-danger remove-product">Remove</button>
            </div>
        </div>

        <button type="button" class="btn btn-primary" id="add-product">Add Product</button>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>

@endsection


@section('script')

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let productIndex = 1;
    
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
