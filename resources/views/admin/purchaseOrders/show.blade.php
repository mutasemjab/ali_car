@extends('layouts.admin')

@section('title')
    {{ __('messages.purchaseOrder') }} #{{ $purchaseOrder->id }}
@endsection

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>{{ __('messages.purchaseOrder') }} #{{ $purchaseOrder->id }}</h2>
            <h6 class="text-muted">
                {{ __('messages.status') }}:
                <span class="badge {{ $purchaseOrder->status == 1 ? 'bg-primary' : 'bg-success' }}">
                    {{ __('messages.' . $purchaseOrder->status_text) }}
                </span>
            </h6>
        </div>
        <div class="col-md-4 text-end">
            <div class="btn-group">
                @if(!$purchaseOrder->isConverted())
                <a href="{{ route('purchaseOrders.edit', $purchaseOrder->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> {{ __('messages.edit') }}
                </a>
                @endif
             
                <a href="{{ route('purchaseOrders.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i> {{ __('messages.allPurchaseOrders') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Convert to Invoice Button -->
    @if(!$purchaseOrder->isConverted())
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="alert alert-info d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-info-circle me-2"></i>
                    {{ __('messages.convertPOtoInvoiceInfo') }}
                </div>
                <a href="{{ route('invoices.createFromPO', $purchaseOrder->id) }}" class="btn btn-success">
                    <i class="fas fa-file-invoice-dollar me-1"></i> {{ __('messages.convertToInvoice') }}
                </a>
            </div>
        </div>
    </div>
    @else
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="alert alert-success d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-check-circle me-2"></i>
                    {{ __('messages.convertedToInvoice') }}
                </div>
                <a href="{{ route('invoices.show', $purchaseOrder->invoice_id) }}" class="btn btn-primary">
                    <i class="fas fa-file-invoice me-1"></i> {{ __('messages.viewInvoice') }} #{{ $purchaseOrder->invoice_id }}
                </a>
            </div>
        </div>
    </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <!-- Header Section -->
            <div class="row mb-4">
                <div class="col-7">
                    <h1 class="mb-1">{{ __('messages.purchaseOrder') }}</h1>
                    <h5 class="text-muted">#{{ $purchaseOrder->id }}</h5>
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
                        <strong>{{ __('messages.dateCreated') }}:</strong>
                        {{ $purchaseOrder->created_at->format('d/m/Y') }}
                    </div>
                    <div>
                        <strong>{{ __('messages.dateOfReceive') }}:</strong>
                        {{ \Carbon\Carbon::parse($purchaseOrder->date_of_receive)->format('d/m/Y') }}
                    </div>
                    <div>
                        <strong>{{ __('messages.preparedBy') }}:</strong>
                        {{ $purchaseOrder->admin->name }}
                    </div>
                </div>
                <div class="col-6 text-end">
                    <div class="p-3 bg-light rounded">
                        <strong>{{ __('messages.status') }}:</strong>
                        <span class="badge {{ $purchaseOrder->status == 1 ? 'bg-primary' : 'bg-success' }}">
                            {{ __('messages.' . $purchaseOrder->status_text) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <h4>{{ __('messages.products') }}</h4>
            <div class="table-responsive mb-4">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('messages.Name') }}</th>
                            <th scope="col">{{ __('messages.quantity') }}</th>
                            <th scope="col">{{ __('messages.Note') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchaseOrder->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->note }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Notes Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="bg-light p-3 rounded">
                        <h5>{{ __('messages.Note') }}</h5>
                        <p class="mb-0">{{ $purchaseOrder->note ?? __('messages.noNotes') }}</p>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mb-4">
        @if(!$purchaseOrder->isConverted())
            <a href="{{ route('purchaseOrders.edit', $purchaseOrder->id) }}" class="btn btn-primary me-2">
                <i class="fas fa-edit"></i> {{ __('messages.edit') }}
            </a>
            <form action="{{ route('purchaseOrders.destroy', $purchaseOrder->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('messages.confirmDelete') }}')">
                    <i class="fas fa-trash"></i> {{ __('messages.delete') }}
                </button>
            </form>
        @endif

        <button class="btn btn-secondary me-2" onclick="window.print();">
            <i class="fas fa-print"></i> {{ __('messages.print') }}
        </button>
        <a href="{{ route('purchaseOrders.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> {{ __('messages.backToList') }}
        </a>
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
        .btn, form, .alert {
            display: none !important;
        }
    }
</style>
@endsection
