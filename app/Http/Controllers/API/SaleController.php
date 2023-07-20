<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Sale;

class SaleController extends Controller
{
    public function processPurchase(Request $request)
    {
        $productId = $request->input('product_id');
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['error' => '指定された商品が見つかりません。'], 404);
        }

        if ($product->stock < 1) {
            return response()->json(['error' => '在庫が不足しています。'], 400);
        }

        $product->decrement('stock');
        //書き換え
        $sale =DB::table('sales')
            ->insert([ 'product_id' => $productId, 'created_at' => NOW(), 'updated_at' => NOW(), ]);
            DB::commit();

        return response()->json(['message' => '購入が完了しました。', 'sale' => $sale]);
    }
    
    public function test() {
        return response()->json("確認しました");
    }

}
