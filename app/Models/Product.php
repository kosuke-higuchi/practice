<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Product extends Model
{
    public function getList() {
        $products = DB::table('products')
        ->join('companies', 'products.company_id', '=', 'companies.id')
        ->select('products.id','company_name','product_name','price','stock','comment','img_path')
        ->get();

        return $products;
    }

    public function searchList($keyword) {
        $products = DB::table('products')
        ->join('companies', 'products.company_id', '=', 'companies.id')
        ->select('products.id','company_name','product_name','price','stock','comment','img_path')
        ->where('product_name', 'LIKE', "%{$keyword}%")
        ->get();

        return $products;
    }

    public function searchCompany($company) {
        $products = DB::table('products')
        ->join('companies', 'products.company_id', '=', 'companies.id')
        ->select('products.id','company_name','product_name','price','stock','comment','img_path')
        ->where('company_id', 'LIKE', $company)
        ->get();

        return $products;
    }

    public function searchListAndCompany($keyword, $company_id) {
        $products = DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.id', 'company_name', 'product_name', 'price', 'stock', 'comment', 'img_path')
            ->where('product_name', 'LIKE', "%{$keyword}%")
            ->where('company_id', $company_id)
            ->get();
    
        return $products;
    }

    public function filterByPriceAndStockRange($search, $minPrice, $maxPrice, $minStock, $maxStock) {
        $search = $search->whereBetween('price', [$minPrice, $maxPrice])
            ->whereBetween('stock', [$minStock, $maxStock]);

        return $search;
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
