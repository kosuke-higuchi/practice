<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Product extends Model
{
    public function getList() {
        // JOIN
        $products = DB::table('products')
        ->join('companies', 'products.company_id', '=', 'companies.id')
        ->select('products.id','company_name','product_name','price','stock','comment','img_path')
        
        ->get();

        return $products;
    }

    public function searchList($keyword) {
        // JOIN
        $products = DB::table('products')
        ->join('companies', 'products.company_id', '=', 'companies.id')
        ->select('products.id','company_name','product_name','price','stock','comment','img_path')
        ->where('product_name', 'LIKE', "%{$keyword}%")
        ->get();
        // ddd($products);
        return $products;
    }

    public function searchCompany($company) {
        // JOIN
        $products = DB::table('products')
        ->where('company_id', 'LIKE', $company)
        ->join('companies', 'products.company_id', '=', 'companies.id')
        ->select('products.id','company_name','product_name','price','stock','comment','img_path')
        ->get();
        // ddd($products);
        return $products;
    }

    public function registProduct($input) {
        // 登録処理
        DB::table('products')
            ->insert([
            'product_name' => $input['product_name'],
            'company_id' => $input['company_id'],
            'price' => $input['price'],
            'stock' => $input['stock'],
            'comment' => $input['comment'],
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
}
