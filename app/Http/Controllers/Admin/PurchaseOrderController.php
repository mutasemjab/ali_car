<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Country;
use App\Models\Product;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{

    public function index()
    {

        $data = PurchaseOrder::paginate(PAGINATION_COUNT);

        return view('admin.purchaseOrders.index', ['data' => $data]);
    }

    public function create()
    {
        if (auth()->user()->can('purchaseOrder-add')) {
            return view('admin.purchaseOrders.create');
        } else {
            return redirect()->back()
                ->with('error', "Access Denied");
        }
    }



    public function store(Request $request)
    {
        $request->validate([
            'date_of_receive' => 'required|date',
            'note' => 'nullable|string',
            'items' => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.note' => 'nullable|string',
        ]);

        $purchaseOrder = PurchaseOrder::create([
            'date_of_receive' => $request->date_of_receive,
            'note' => $request->note,
            'created_by' => auth()->user()->id,
        ]);

        foreach ($request->items as $item) {
            // Find the product by name and get its ID
        $product = Product::where('name_ar', $item['name'])->first();

            if ($product) {
                // Create purchase order item with product_id instead of name
                $purchaseOrder->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'note' => $item['note'] ?? null,
                ]);
            }
        }

        return redirect()->route('purchaseOrders.index')->with('success', 'Purchase order created successfully.');
    }

    public function show($id)
    {
        $purchaseOrder = PurchaseOrder::with('items')->findOrFail($id);
        return view('admin.purchaseOrders.show', compact('purchaseOrder'));
    }

    public function edit($id)
    {
        $purchaseOrder = PurchaseOrder::with('items')->findOrFail($id);
        return view('admin.purchaseOrders.edit', compact('purchaseOrder'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date_of_receive' => 'required|date',
            'note' => 'nullable|string',
            'items' => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.note' => 'nullable|string',
        ]);

        $purchaseOrder = PurchaseOrder::findOrFail($id);
        $purchaseOrder->update([
            'date_of_receive' => $request->date_of_receive,
            'note' => $request->note,
        ]);


        // Delete existing items and add new ones
        $purchaseOrder->items()->delete();

        foreach ($request->items as $item) {
            // Find the product by name and get its ID
            $product = Product::where('name_ar', $item['name'])->first();

            if ($product) {
                // Create purchase order item with product_id instead of name
                $purchaseOrder->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'note' => $item['note'] ?? null,
                ]);
            }
        }

        return redirect()->route('purchaseOrders.index')->with('success', 'Purchase order updated successfully.');
    }

    public function destroy($id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);
        $purchaseOrder->delete();

        return redirect()->route('purchaseOrders.index')->with('success', 'Purchase order deleted successfully.');
    }


}
