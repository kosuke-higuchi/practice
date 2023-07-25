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
        // トランザクション開始
        DB::beginTransaction();
        try {
            $productId = $request->input('product_id');
            $product = Product::find($productId);

            // 商品が見つからない場合
            if (!$product) {
                DB::rollback();
                return response()->json(['error' => '指定された商品が見つかりません。'], 404);
            }
            // 在庫不足の場合
            if ($product->stock < 1) {
                DB::rollback();
                return response()->json(['error' => '在庫が不足しています。'], 400);
            }

            // 在庫数を減らす
            $product->decrement('stock');
            $sale = DB::table('sales')->insert([
                'product_id' => $productId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();
            return response()->json(['message' => '購入が完了しました。', 'sale' => $sale]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'エラーが発生しました。'], 500);
        }
    }
    
}
