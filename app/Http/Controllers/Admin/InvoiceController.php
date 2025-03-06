<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\PurchaseOrder;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the invoices.
     */
    public function index()
    {
        $invoices = Invoice::with('creator')->latest()->paginate(10);
        return view('admin.invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new invoice.
     */
    public function create()
    {
        $customers = User::get();
        return view('admin.invoices.create',compact('customers'));
    }

    /**
     * Create an invoice from a purchase order.
     */
    public function createFromPurchaseOrder(PurchaseOrder $purchaseOrder)
    {
        // Check if this PO is already converted to an invoice
        if ($purchaseOrder->isConverted()) {
            return redirect()->route('invoices.edit', $purchaseOrder->invoice->id)
                ->with('warning', __('messages.purchaseOrderAlreadyConverted'));
        }

        // Load purchase order with its items
        $purchaseOrder->load('items.product');

        return view('admin.invoices.create_from_po', compact('purchaseOrder'));
    }

    /**
     * Store a newly created invoice in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'discount' => 'nullable|numeric|min:0',
            'note' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.note' => 'nullable|string',
            'purchase_order_id' => 'nullable|exists:purchase_orders,id'
        ]);

        try {
            DB::beginTransaction();

            // Calculate totals
            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += $item['quantity'] * $item['unit_price'];
            }

            $taxRate = $request->tax_rate ?? 0;
            $taxAmount = $subtotal * ($taxRate / 100);
            $discount = $request->discount ?? 0;
            $total = $subtotal + $taxAmount - $discount;

            // Create the invoice
            $invoice = Invoice::create([
                'purchase_order_id' => $request->purchase_order_id,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'subtotal' => $subtotal,
                'tax_rate' => $taxRate,
                'tax_amount' => $taxAmount,
                'discount' => $discount,
                'total' => $total,
                'note' => $request->note,
                'status' => 1, // Pending
                'created_by' => auth()->id()
            ]);

            // Create invoice items
            foreach ($request->items as $item) {
                $amount = $item['quantity'] * $item['unit_price'];

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'amount' => $amount,
                    'note' => $item['note'] ?? null
                ]);
            }

            // If this invoice was created from a purchase order, update the purchase order
            if ($request->purchase_order_id) {
                PurchaseOrder::find($request->purchase_order_id)->update([
                    'status' => 2, // Converted to invoice
                    'invoice_id' => $invoice->id
                ]);
            }

            DB::commit();

            return redirect()->route('invoices.show', $invoice->id)
                ->with('success', __('messages.invoiceCreated'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', __('messages.invoiceCreationFailed') . ': ' . $e->getMessage());
        }
    }

    /**
     * Display the specified invoice.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['items.product', 'creator', 'purchaseOrder']);
        return view('admin.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified invoice.
     */
    public function edit(Invoice $invoice)
    {
        $invoice->load(['items.product', 'purchaseOrder']);
        return view('admin.invoices.edit', compact('invoice'));
    }

    /**
     * Update the specified invoice in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'discount' => 'nullable|numeric|min:0',
            'note' => 'nullable|string',
            'status' => 'required|integer|in:1,2,3',
            'items' => 'required|array|min:1',
            'items.*.id' => 'nullable|exists:invoice_items,id',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.note' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            // Calculate totals
            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += $item['quantity'] * $item['unit_price'];
            }

            $taxRate = $request->tax_rate ?? 0;
            $taxAmount = $subtotal * ($taxRate / 100);
            $discount = $request->discount ?? 0;
            $total = $subtotal + $taxAmount - $discount;

            // Update the invoice
            $invoice->update([
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'subtotal' => $subtotal,
                'tax_rate' => $taxRate,
                'tax_amount' => $taxAmount,
                'discount' => $discount,
                'total' => $total,
                'note' => $request->note,
                'status' => $request->status
            ]);

            // Get existing item IDs
            $existingItemIds = $invoice->items->pluck('id')->toArray();
            $updatedItemIds = [];

            // Update or create invoice items
            foreach ($request->items as $itemData) {
                $amount = $itemData['quantity'] * $itemData['unit_price'];

                if (isset($itemData['id'])) {
                    // Update existing item
                    $item = InvoiceItem::find($itemData['id']);
                    $item->update([
                        'product_id' => $itemData['product_id'],
                        'quantity' => $itemData['quantity'],
                        'unit_price' => $itemData['unit_price'],
                        'amount' => $amount,
                        'note' => $itemData['note'] ?? null
                    ]);
                    $updatedItemIds[] = $item->id;
                } else {
                    // Create new item
                    $item = InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'product_id' => $itemData['product_id'],
                        'quantity' => $itemData['quantity'],
                        'unit_price' => $itemData['unit_price'],
                        'amount' => $amount,
                        'note' => $itemData['note'] ?? null
                    ]);
                    $updatedItemIds[] = $item->id;
                }
            }

            // Delete items that were not in the update
            $itemsToDelete = array_diff($existingItemIds, $updatedItemIds);
            InvoiceItem::whereIn('id', $itemsToDelete)->delete();

            DB::commit();

            return redirect()->route('invoices.show', $invoice->id)
                ->with('success', __('messages.invoiceUpdated'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', __('messages.invoiceUpdateFailed') . ': ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified invoice from storage.
     */
    public function destroy(Invoice $invoice)
    {
        try {
            // If this invoice was converted from a purchase order, reset the PO status
            if ($invoice->purchase_order_id) {
                PurchaseOrder::where('id', $invoice->purchase_order_id)->update([
                    'status' => 1, // Back to PO status
                    'invoice_id' => null
                ]);
            }

            $invoice->delete();
            return redirect()->route('invoices.index')
                ->with('success', __('messages.invoiceDeleted'));
        } catch (\Exception $e) {
            return back()->with('error', __('messages.invoiceDeletionFailed') . ': ' . $e->getMessage());
        }
    }
}
