<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Product extends Model
{
    public function sales() {
        return $this->hasMany(Sale::class);
    }

    public function getList() {
        $products = DB::table('products')
        ->join('companies', 'products.company_id', '=', 'companies.id')
        ->select('products.id','company_name','product_name','price','stock','comment','img_path')
        ->get();

        return $products;
    }

    // ローカルスコープ
    // 一覧表示
    public function scopeList($query) {
        return $query->join('companies', 'products.company_id', '=', 'companies.id')
        ->select('products.id','company_name','product_name','price','stock','comment','img_path');
    }

    // 商品名検索
    public function scopeSearchList($query, $keyword) {
        return $query->where('product_name', 'LIKE', "%{$keyword}%");
    }

    // メーカー名検索
    public function scopeSearchCompany($query, $company) {
        return $query->where('company_id', 'LIKE', $company);
    }

    // 価格、在庫数検索
    public function scopeFilterByPriceAndStockRange($query, $minPrice, $maxPrice, $minStock, $maxStock) {
        return $query->whereBetween('price', [$minPrice, $maxPrice])
            ->whereBetween('stock', [$minStock, $maxStock]);
    }

    public function registProduct($input) {
        DB::table('products')
            ->insert([
            'product_name' => $input['product_name'],
            'company_id' => $input['company_id'],
            'price' => $input['price'],
            'stock' => $input['stock'],
            'comment' => $input['comment'],
            'img_path' => $input['img_path'],
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function whereId($id) {
        $details = DB::table('products')
        ->join('companies', 'products.company_id', '=', 'companies.id')
        ->select('products.id','company_name','product_name','price','stock','comment','img_path')
        ->where('products.id', '=', $id)
        ->first();

        return $details;
    }

    public function updateProduct($input, $id) {
        DB::table('products')
            ->where('products.id', '=', $id)
            ->update([
            'product_name' => $input['product_name'],
            'company_id' => $input['company_id'],
            'price' => $input['price'],
            'stock' => $input['stock'],
            'comment' => $input['comment'],
            'img_path' => $input['img_path'],
            'updated_at' => now()
        ]);
    }
}
