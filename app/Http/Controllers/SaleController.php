<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function processPurchase(Request $request) {
        $productId = $request->input('id');
        $product = product::findOrFail($productId);

        if ($product->stock > 0) {
            $product->decrement('stock');
            
            $sale = new Sale();
            $sale->product_id = $productId;
            $sale->save();

            return response()->json(['message' => 'Purchase processed successfully']);
        } else {
            return response()->json(['message' => 'Product out of stock'], 400);
        }
    }

    public function test(Request $request) {
        $test = '確認です';
        return view('test', compact('test'));
    }
}
