<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;

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

    public function test() {
        return response()->json(['message' => '確認しました']);
    }

}
