@extends('layouts.admin')

@section('title')
    {{ __('messages.purchaseOrders') }}
@endsection

@section('content')
<div class="container">
    <h2>{{ __('messages.createPurchaseOrder') }}</h2>

    <form action="{{ route('purchaseOrders.store') }}" method="post">
        @csrf
        <button type="submit" class="btn btn-success">{{ __('messages.save') }}</button>

        <div class="mb-3">
            <label for="date_of_receive" class="form-label">{{ __('messages.dateOfReceive') }}</label>
            <input type="date" name="date_of_receive" id="date_of_receive" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="note" class="form-label">{{ __('messages.Note') }}</label>
            <textarea name="note" id="note" class="form-control"></textarea>
        </div>

        <h4>{{ __('messages.products') }}</h4>
        <table class="table table-bordered" id="productsTable">
            <thead>
                <tr>
                    <th>{{ __('messages.Name') }}</th>
                    <th>{{ __('messages.quantity') }}</th>
                    <th>{{ __('messages.Note') }}</th>
                    <th>{{ __('messages.Action') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <input type="text" name="items[0][name]" class="form-control product-search" required autocomplete="off">
                        <div class="product-suggestions" style="position: absolute; background: white; border: 1px solid #ddd; display: none;"></div>
                    </td>
                    <td><input type="number" name="items[0][quantity]" class="form-control" required></td>
                    <td><input type="text" name="items[0][note]" class="form-control"></td>
                    <td><button type="button" class="btn btn-danger remove-product">-</button></td>
                </tr>
            </tbody>
        </table>

        <button type="button" class="btn btn-primary" id="add-product">+</button>
    </form>
</div>
@endsection

@section('script')
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".product-search").forEach(input => {
        input.addEventListener("input", function () {
            let query = this.value.trim();
            let suggestionBox = this.nextElementSibling;

            if (query.length > 1) {
                let searchUrl = "{{ route('products.search') }}?query=" + encodeURIComponent(query);

                fetch(searchUrl)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("Network response was not OK");
                        }
                        return response.json();
                    })
                    .then(data => {
                        suggestionBox.innerHTML = "";
                        suggestionBox.style.display = "block";
                        suggestionBox.style.width = input.offsetWidth + "px"; // Set width same as input field

                        if (data.length === 0) {
                            // Display "Not Found" if no products are available
                            let notFound = document.createElement("div");
                            notFound.textContent = "No products found";
                            notFound.style.padding = "10px";
                            notFound.style.color = "red";
                            suggestionBox.appendChild(notFound);
                        } else {
                            data.forEach(product => {
                                let suggestion = document.createElement("div");
                                suggestion.textContent = product.name;
                                suggestion.style.padding = "10px";
                                suggestion.style.cursor = "pointer";
                                suggestion.style.borderBottom = "1px solid #ddd";
                                suggestion.style.background = "#fff";
                                suggestion.style.width = "100%";

                                suggestion.addEventListener("click", function () {
                                    input.value = product.name;
                                    suggestionBox.style.display = "none";
                                });

                                suggestionBox.appendChild(suggestion);
                            });
                        }
                    })
                    .catch(error => {
                        console.error("Error fetching product data:", error);
                    });
            } else {
                suggestionBox.style.display = "none";
            }
        });

        // Hide dropdown when clicking outside
        document.addEventListener("click", function (event) {
            if (!input.parentElement.contains(event.target)) {
                input.nextElementSibling.style.display = "none";
            }
        });
    });
});



</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    let productIndex = 1;

    document.getElementById("add-product").addEventListener("click", function() {
        let newRow = `
            <tr>
               <td>
                        <input type="text" name="items[${productIndex}][name]" class="form-control product-search" required autocomplete="off">
                        <div class="product-suggestions" style="position: absolute; background: white; border: 1px solid #ddd; display: none;"></div>
                    </td>
                <td><input type="number" name="items[${productIndex}][quantity]" class="form-control" required></td>
                <td><input type="text" name="items[${productIndex}][note]" class="form-control"></td>
                <td><button type="button" class="btn btn-danger remove-product">-</button></td>
            </tr>
        `;
        document.querySelector("#productsTable tbody").insertAdjacentHTML("beforeend", newRow);
        productIndex++;
    });

    document.querySelector("#productsTable tbody").addEventListener("click", function(e) {
        if (e.target.classList.contains("remove-product")) {
            e.target.closest("tr").remove();
        }
    });
});
</script>
@endsection
