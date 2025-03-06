@extends('layouts.admin')

@section('title')
    {{ __('messages.invoice') }} #{{ $invoice->id }}
@endsection

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>{{ __('messages.invoice') }} #{{ $invoice->id }}</h2>
            @if($invoice->purchaseOrder)
                <h6 class="text-muted">
                    {{ __('messages.fromPurchaseOrder') }}:
                    <a href="{{ route('purchaseOrders.show', $invoice->purchaseOrder->id) }}">#{{ $invoice->purchaseOrder->id }}</a>
                </h6>
            @endif
        </div>
        <div class="col-md-4 text-end">
            <div class="btn-group">
                <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> {{ __('messages.edit') }}
                </a>
                <a href="{{ route('invoices.pdf', $invoice->id) }}" class="btn btn-info" target="_blank">
                    <i class="fas fa-file-pdf"></i> {{ __('messages.downloadPDF') }}
                </a>
                <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i> {{ __('messages.allInvoices') }}
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4" id="invoice-document">
        <div class="card-body p-4">
            <!-- Header Section -->
            <div class="row mb-4">
                <div class="col-7">
                    <h1 class="mb-1">{{ __('messages.invoice') }}</h1>
                    <h5 class="text-muted">#{{ $invoice->id }}</h5>
                </div>
                <div class="col-5 text-end">
                    <img src="{{ asset('logo.png') }}" alt="Company Logo" style="max-height: 80px">
                    <p class="mt-2 mb-0"><strong>{{ config('app.name') }}</strong></p>
                    <p class="mb-0">{{ config('app.address', '123 Business Street') }}</p>
                    <p class="mb-0">{{ config('app.phone', '+1 234 567 890') }}</p>
                </div>
            </div>

            <hr>

            <!-- Date Information -->
            <div class="row mb-4">
                <div class="col-6">
                    <div class="mb-2">
                        <strong>{{ __('messages.invoiceDate') }}:</strong>
                        {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}
                    </div>
                    <div class="mb-2">
                        <strong>{{ __('messages.dueDate') }}:</strong>
                        {{ \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') }}
                    </div>
                    @if($invoice->purchaseOrder)
                    <div>
                        <strong>{{ __('messages.poReference') }}:</strong>
                        #{{ $invoice->purchaseOrder->id }}
                    </div>
                    @endif
                </div>
                <div class="col-6 text-end">
                    <div class="p-3 bg-light rounded">
                        <strong>{{ __('messages.status') }}:</strong>
                        <span class="badge
                            @if($invoice->status == 1) bg-warning
                            @elseif($invoice->status == 2) bg-success
                            @else bg-danger @endif">
                            {{ __('messages.' . $invoice->status_text) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <h4>{{ __('messages.items') }}</h4>
            <div class="table-responsive mb-4">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" width="50">#</th>
                            <th scope="col">{{ __('messages.product') }}</th>
                            <th scope="col" width="100">{{ __('messages.quantity') }}</th>
                            <th scope="col" width="150">{{ __('messages.unitPrice') }}</th>
                            <th scope="col" width="150">{{ __('messages.amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $item->product->name }}</strong>
                                @if($item->note)
                                    <small class="d-block text-muted">{{ $item->note }}</small>
                                @endif
                            </td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">${{ number_format($item->unit_price, 2) }}</td>
                            <td class="text-end">${{ number_format($item->amount, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totals Section -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="bg-light p-3 rounded">
                        <h5>{{ __('messages.Note') }}</h5>
                        <p class="mb-0">{{ $invoice->note ?? __('messages.noNotes') }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <strong>{{ __('messages.subtotal') }}:</strong>
                                <span>${{ number_format($invoice->subtotal, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <strong>{{ __('messages.tax') }} ({{ $invoice->tax_rate }}%):</strong>
                                <span>${{ number_format($invoice->tax_amount, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <strong>{{ __('messages.discount') }}:</strong>
                                <span>${{ number_format($invoice->discount, 2) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>{{ __('messages.total') }}:</strong>
                                <span class="h4">${{ number_format($invoice->total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Terms Section -->
            <div class="row mt-5">
                <div class="col-12">
                    <h5>{{ __('messages.paymentTerms') }}</h5>
                    <p>{{ __('messages.paymentTermsDescription') }}</p>
                </div>
            </div>

            <!-- Footer Section -->
            <div class="row mt-5 border-top pt-3">
                <div class="col-md-12 text-center">
                    <p class="mb-0">{{ __('messages.thankyouMessage') }}</p>
                    <p class="mb-0">{{ config('app.name') }} - {{ config('app.email', 'contact@example.com') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('messages.confirmDelete') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> {{ __('messages.delete') }}
                                </button>
                            </form>
                        </div>

                        <div>
                            @if($invoice->status == 1) <!-- Pending -->
                            <form action="{{ route('invoices.update', $invoice->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="2"> <!-- Mark as Paid -->
                                <input type="hidden" name="invoice_date" value="{{ $invoice->invoice_date }}">
                                <input type="hidden" name="due_date" value="{{ $invoice->due_date }}">
                                <input type="hidden" name="tax_rate" value="{{ $invoice->tax_rate }}">
                                <input type="hidden" name="discount" value="{{ $invoice->discount }}">
                                <input type="hidden" name="note" value="{{ $invoice->note }}">
                                <!-- We need to include items data too -->
                                @foreach($invoice->items as $index => $item)
                                    <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                                    <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $item->product_id }}">
                                    <input type="hidden" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}">
                                    <input type="hidden" name="items[{{ $index }}][unit_price]" value="{{ $item->unit_price }}">
                                    <input type="hidden" name="items[{{ $index }}][note]" value="{{ $item->note }}">
                                @endforeach

                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check"></i> {{ __('messages.markAsPaid') }}
                                </button>
                            </form>
                            @endif

                            <button class="btn btn-info ms-2" onclick="window.print();">
                                <i class="fas fa-print"></i> {{ __('messages.print') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body {
            width: 210mm;
            height: 297mm;
            margin: 0;
            padding: 10mm;
        }
        .container {
            width: 100%;
            max-width: 100%;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        .no-print, .no-print * {
            display: none !important;
        }
        .table-dark {
            color: #000 !important;
            background-color: #f8f9fa !important;
        }
        .table-dark th {
            border-color: #dee2e6 !important;
        }
        .badge.bg-success {
            border: 1px solid #28a745;
            color: #28a745 !important;
            background-color: transparent !important;
        }
        .badge.bg-warning {
            border: 1px solid #ffc107;
            color: #ffc107 !important;
            background-color: transparent !important;
        }
        .badge.bg-danger {
            border: 1px solid #dc3545;
            color: #dc3545 !important;
            background-color: transparent !important;
        }
        .btn, form, .card:last-child {
            display: none !important;
        }
        #invoice-document {
            margin: 0 !important;
        }
    }
</style>
@endsection
