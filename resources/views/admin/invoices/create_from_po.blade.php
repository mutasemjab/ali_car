@extends('layouts.admin')

@section('title')
    {{ __('messages.createInvoiceFromPO') }}
@endsection

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>{{ __('messages.createInvoiceFromPO') }}</h2>
            <h5 class="text-muted">{{ __('messages.purchaseOrder') }} #{{ $purchaseOrder->id }}</h5>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('purchaseOrders.show', $purchaseOrder->id) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> {{ __('messages.backToPO') }}
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('invoices.store') }}" method="post" id="invoiceForm">
                @csrf
                <input type="hidden" name="purchase_order_id" value="{{ $purchaseOrder->id }}">

                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <label for="invoice_date" class="form-label">{{ __('messages.invoiceDate') }} *</label>
                        <input type="date" id="invoice_date" name="invoice_date" class="form-control @error('invoice_date') is-invalid @enderror"
                            value="{{ old('invoice_date', now()->format('Y-m-d')) }}" required>
                        @error('invoice_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="due_date" class="form-label">{{ __('messages.dueDate') }} *</label>
                        <input type="date" id="due_date" name="due_date" class="form-control @error('due_date') is-invalid @enderror"
                            value="{{ old('due_date', now()->addDays(30)->format('Y-m-d')) }}" required>
                        @error('due_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="tax_rate" class="form-label">{{ __('messages.taxRate') }} (%)</label>
                        <input type="number" id="tax_rate" name="tax_rate" class="form-control @error('tax_rate') is-invalid @enderror"
                            step="0.01" min="0" max="100" value="{{ old('tax_rate', 0) }}">
                        @error('tax_rate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="bg-light p-3 rounded">
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="note" class="form-label">{{ __('messages.Note') }}</label>
                                    <textarea id="note" name="note" class="form-control @error('note') is-invalid @enderror"
                                        rows="3">{{ old('note', $purchaseOrder->note) }}</textarea>
                                    @error('note')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="discount" class="form-label">{{ __('messages.discount') }}</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">$</span>
                                        <input type="number" id="discount" name="discount" class="form-control @error('discount') is-invalid @enderror"
                                            step="0.01" min="0" value="{{ old('discount', 0) }}">
                                        @error('discount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h4>{{ __('messages.items') }}</h4>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered" id="itemsTable">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('messages.product') }}</th>
                                <th style="width: 100px;">{{ __('messages.quantity') }}</th>
                                <th style="width: 150px;">{{ __('messages.unitPrice') }}</th>
                                <th style="width: 150px;">{{ __('messages.amount') }}</th>
                                <th>{{ __('messages.Note') }}</th>
                                <th style="width: 80px;">{{ __('messages.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchaseOrder->items as $index => $item)
                            <tr>
                                <td>
                                    <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $item->product_id }}">
                                    <input type="text" class="form-control" value="{{ $item->product->name }}" readonly>
                                </td>
                                <td>
                                    <input type="number" name="items[{{ $index }}][quantity]" class="form-control item-quantity"
                                        value="{{ $item->quantity }}" min="1" required>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" name="items[{{ $index }}][unit_price]" class="form-control item-price"
                                            step="0.01" min="0" value="{{ old('items.'.$index.'.unit_price', $item->product->price ?? 0) }}" required>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="text" class="form-control item-amount" readonly>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" name="items[{{ $index }}][note]" class="form-control"
                                        value="{{ old('items.'.$index.'.note', $item->note) }}">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger remove-item">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary" id="add-item">
                            <i class="fas fa-plus"></i> {{ __('messages.addItem') }}
                        </button>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <button type="submit" class="btn btn-success btn-lg w-100">
                                    <i class="fas fa-save"></i> {{ __('messages.createInvoice') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <strong>{{ __('messages.subtotal') }}:</strong>
                                    <span id="subtotal">$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <strong>{{ __('messages.tax') }} (<span id="tax-rate-display">0</span>%):</strong>
                                    <span id="tax-amount">$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <strong>{{ __('messages.discount') }}:</strong>
                                    <span id="discount-display">$0.00</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <strong>{{ __('messages.total') }}:</strong>
                                    <span id="total" class="h4">$0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener("DOMContentLoaded", function() {
    let productSearchUrl = "{{ route('products.search') }}";
    let itemIndex = {{ count($purchaseOrder->items) }};

    // Initial calculation of all amounts
    calculateAllAmounts();

    // Add new item
    document.getElementById("add-item").addEventListener("click", function() {
        let newRow = `
            <tr>
                <td>
                    <div class="position-relative">
                        <input type="text" class="form-control product-search" autocomplete="off" required>
                        <input type="hidden" name="items[${itemIndex}][product_id]" class="product-id" required>
                        <div class="product-suggestions" style="position: absolute; z-index: 1000; width: 100%; display: none;"></div>
                    </div>
                </td>
                <td>
                    <input type="number" name="items[${itemIndex}][quantity]" class="form-control item-quantity" value="1" min="1" required>
                </td>
                <td>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" name="items[${itemIndex}][unit_price]" class="form-control item-price" step="0.01" min="0" value="0.00" required>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control item-amount" readonly>
                    </div>
                </td>
                <td>
                    <input type="text" name="items[${itemIndex}][note]" class="form-control">
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger remove-item">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        document.querySelector("#itemsTable tbody").insertAdjacentHTML("beforeend", newRow);
        itemIndex++;

        // Setup product search for the new row
        setupProductSearch(document.querySelectorAll(".product-search")[document.querySelectorAll(".product-search").length - 1]);
    });

    // Remove item
    document.querySelector("#itemsTable tbody").addEventListener("click", function(e) {
        if (e.target.closest(".remove-item")) {
            e.target.closest("tr").remove();
            calculateAllAmounts();
        }
    });

    // Calculate amount when quantity or price changes
    document.querySelector("#itemsTable tbody").addEventListener("input", function(e) {
        if (e.target.classList.contains("item-quantity") || e.target.classList.contains("item-price")) {
            calculateRowAmount(e.target.closest("tr"));
            calculateAllAmounts();
        }
    });

    // Calculate totals when tax rate or discount changes
    document.getElementById("tax_rate").addEventListener("input", calculateAllAmounts);
    document.getElementById("discount").addEventListener("input", calculateAllAmounts);

    // Setup product search for existing rows
    document.querySelectorAll(".product-search").forEach(setupProductSearch);

    // Function to setup product search
    function setupProductSearch(input) {
        if (!input) return;

        input.addEventListener("input", function() {
            let query = this.value.trim();
            let suggestionBox = this.parentElement.querySelector(".product-suggestions");

            if (query.length > 1) {
                fetch(`${productSearchUrl}?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        suggestionBox.innerHTML = "";
                        suggestionBox.style.display = "block";

                        if (data.length === 0) {
                            let notFound = document.createElement("div");
                            notFound.textContent = "{{ __('messages.noProductsFound') }}";
                            notFound.className = "p-2 border-bottom bg-white text-danger";
                            suggestionBox.appendChild(notFound);
                        } else {
                            data.forEach(product => {
                                let suggestion = document.createElement("div");
                                suggestion.textContent = product.name;
                                suggestion.className = "p-2 border-bottom bg-white";
                                suggestion.style.cursor = "pointer";

                                suggestion.addEventListener("click", function() {
                                    input.value = product.name;
                                    input.parentElement.querySelector(".product-id").value = product.id;

                                    // Set price if available
                                    let priceInput = input.closest("tr").querySelector(".item-price");
                                    if (priceInput && product.price) {
                                        priceInput.value = product.price;
                                    }

                                    calculateRowAmount(input.closest("tr"));
                                    calculateAllAmounts();
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
        document.addEventListener("click", function(event) {
            if (!input.parentElement.contains(event.target)) {
                input.parentElement.querySelector(".product-suggestions").style.display = "none";
            }
        });
    }

    // Calculate amount for a single row
    function calculateRowAmount(row) {
        let quantity = parseFloat(row.querySelector(".item-quantity").value) || 0;
        let price = parseFloat(row.querySelector(".item-price").value) || 0;
        let amount = quantity * price;

        row.querySelector(".item-amount").value = amount.toFixed(2);
    }

    // Calculate all amounts and totals
    function calculateAllAmounts() {
        // Calculate each row
        document.querySelectorAll("#itemsTable tbody tr").forEach(row => {
            calculateRowAmount(row);
        });

        // Calculate subtotal
        let subtotal = 0;
        document.querySelectorAll(".item-amount").forEach(input => {
            subtotal += parseFloat(input.value) || 0;
        });

        // Get tax rate and discount
        let taxRate = parseFloat(document.getElementById("tax_rate").value) || 0;
        let discount = parseFloat(document.getElementById("discount").value) || 0;

        // Calculate tax amount
        let taxAmount = subtotal * (taxRate / 100);

        // Calculate total
        let total = subtotal + taxAmount - discount;

        // Update display
        document.getElementById("subtotal").textContent = "$" + subtotal.toFixed(2);
        document.getElementById("tax-rate-display").textContent = taxRate.toFixed(2);
        document.getElementById("tax-amount").textContent = "$" + taxAmount.toFixed(2);
        document.getElementById("discount-display").textContent = "$" + discount.toFixed(2);
        document.getElementById("total").textContent = "$" + total.toFixed(2);
    }
});
</script>
@endsection
