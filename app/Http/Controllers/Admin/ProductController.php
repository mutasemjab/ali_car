<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CardPackage;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\ProductUnit;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{

    public function search(Request $request)
    {
        $query = $request->input('term');
        $products = Product::where('name_ar', 'LIKE', "%{$query}%")
            ->orWhere('number', 'LIKE', "%{$query}%")
            ->with([
                'unit:id,name_ar'
            ])
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name_ar,
                    'unit' => [
                        'id' => $product->unit->id,
                        'name' => $product->unit->name_ar,
                    ],
                    'tax' => $product->tax,
                    'selling_price' => $product->selling_price,
                ];
            });

        return response()->json($products);
    }

    public function index()
    {
        $data = Product::paginate(PAGINATION_COUNT);

        return view('admin.products.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->can('product-add')) {
            $categories = Category::get();
            $units = Unit::get();
            return view('admin.products.create', compact('categories', 'units'));
        } else {
            return redirect()->back()
                ->with('error', "Access Denied");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Create a new product without saving it to the database yet
            $product = new Product();

            $product->number = $request->input('number');
            $product->name_en = $request->input('name_en');
            $product->name_ar = $request->input('name_ar');
            $product->description_en = $request->input('description_en');
            $product->description_ar = $request->input('description_ar');
            $product->tax = $request->input('tax');
            $product->selling_price_for_user = $request->input('selling_price_for_user');
            $product->min_order_for_user = $request->input('min_order_for_user');
            $product->status = $request->input('status');
            $product->category_id = $request->input('category');
            $product->unit_id = $request->input('unit');
            if($product->save()){
            return redirect()->route('products.index')->with(['success' => 'Product created']);
            }
        } catch (\Exception $ex) {
            Log::error($ex);
            return redirect()->back()
                ->with(['error' => 'An error occurred: ' . $ex->getMessage()])
                ->withInput();
        }
    }

    public function edit($id)
    {
        if (auth()->user()->can('product-edit')) {
            $data = Product::findOrFail($id); // Retrieve the category by ID
            $categories = Category::all();
            $units = Unit::all();
            return view('admin.products.edit', ['units' => $units, 'categories' => $categories, 'data' => $data]);
        } else {
            return redirect()->back()
                ->with('error', "Access Denied");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // Find the product by ID
            $product = Product::findOrFail($id);

            $product->number = $request->input('number');
            $product->name_en = $request->input('name_en');
            $product->name_ar = $request->input('name_ar');
            $product->description_en = $request->input('description_en');
            $product->description_ar = $request->input('description_ar');
            $product->tax = $request->input('tax');
            $product->selling_price_for_user = $request->input('selling_price_for_user');
            $product->min_order_for_user = $request->input('min_order_for_user');
            $product->status = $request->input('status');
            $product->category_id = $request->input('category');
            $product->unit_id = $request->input('unit');
            // Save the product
           if( $product->save()){
         
            return redirect()->route('products.index')->with(['success' => 'Product updated']);
           }
        } catch (\Exception $ex) {
            Log::error($ex);
            return redirect()->back()
                ->with(['error' => 'An error occurred: ' . $ex->getMessage()])
                ->withInput();
        }
    }


     public function destroy($id)
    {
        try {
            // Find the product by ID
            $product = Product::find($id);

            if ($product) {
                // Deleting the product will trigger the `deleting` event to detach related card packages
                $flag = $product->delete();

                if ($flag) {
                    return redirect()->back()
                        ->with(['success' => 'Deleted Successfully']);
                } else {
                    return redirect()->back()
                        ->with(['error' => 'Something went wrong']);
                }
            } else {
                return redirect()->back()
                    ->with(['error' => 'Cannot find the specified data']);
            }
        } catch (\Exception $ex) {
            // Log the exception
            Log::error($ex);

            return redirect()->back()
                ->with(['error' => 'Something went wrong: ' . $ex->getMessage()]);
        }
    }

}
