<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function showList(Request $request) {
        $keyword = $request->input('keyword');
        $company_id = $request->input('company_id');
        $model  = new Company();
        $companies = $model->getlist();
        $model = new Product();
        $products = $model->getlist();

        if(isset($keyword)) {
            $products = $model->searchList($keyword);
        }
        if(isset($company_id)) {
            $products = $model->searchCompany($company_id);
        }

        return view('list', compact('products', 'keyword', 'companies'));
    }

    public function registSubmit(ProductRequest $request) {
        $img = $request->file('img_path');
        $input = $request->all();

        if(isset($img)) {
            $img_name = $request->file('img_path')->getClientOriginalName();
            $request->file('img_path')->storeAs('public/img', $img_name);
            $input['img_path'] = '/img/'. $img_name; 
        } else {
            $input['img_path'] = null;
        }

        DB::beginTransaction();
        try {
            $model = new Product();
            $model->registProduct($input);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return back();
        }

        return redirect(route('regist'));
    }

    public function showDetail($id) {
        $model = new Product();
        $details = $model->whereId($id);

        return view('detail', compact('details'));
    }

    public function removeList($id) {
        $product = Product::findOrFail($id);
        $remove_img = $product->img_path;
        if(isset($remove_img)) {
            Storage::disk('public')->delete($remove_img);
        }
        $model = new Product();
        $model->destroy($id);

        return redirect(route('ajaxList'));
    }

    public function detailEdit($id) {
        $model = new Product();
        $details = $model->whereId($id);
        $model  = new Company();
        $companies = $model->getlist();
        
        return view('edit', compact('details', 'companies'));
    }

    public function updateSubmit(ProductRequest $request, $id) {
        $img = $request->file('img_path');
        $existing_img = $request->input('img_path');
        $input = $request->all();
        if(isset($img)) {
            if(isset($existing_img)) {
                Storage::disk('public')->delete($existing_img);
            }
            $img_name = $request->file('img_path')->getClientOriginalName();
            $request->file('img_path')->storeAs('public/img', $img_name);
            $input['img_path'] = '/img/'. $img_name; 
        }
        DB::beginTransaction();
        try {
            $model = new Product();
            $model->updateProduct($input, $id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            ddd($e);
            return back();
        }

        return redirect(route('edit', $id));
    }

    public function ajaxList(Request $request) {
        $keyword = $request->input('keyword');
        $company_id = $request->input('company_id');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $minStock = $request->input('min_stock');
        $maxStock = $request->input('max_stock');

        $model  = new Company();
        $companies = $model->getlist();
        // $model = new Product();
        // $search = $model->getlist();

        // if (isset($minPrice) || isset($maxPrice) || isset($minStock) || isset($maxStock)) {
        //     $minPrice = $request->input('min_price') ?: 0;
        //     $maxPrice = $request->input('max_price') ?: 999999;
        //     $minStock = $request->input('min_stock') ?: 0;
        //     $maxStock = $request->input('max_stock') ?: 999999;
        //     $search = $model->filterByPriceAndStockRange($minPrice, $maxPrice, $minStock, $maxStock);
        // }
        // if (isset($keyword) && isset($company_id)) {
        //     $search = $model->searchListAndCompany($keyword, $company_id);
        // } elseif (isset($keyword)) {
        //     $search = $model->searchList($keyword);
        // } elseif (isset($company_id)) {
        //     $search = $model->searchCompany($company_id);
        // }
            
        $search = Product::list();
        if (isset($company_id)) {
                $search->searchCompany($company_id);
            }
        if (isset($keyword)) {
            $search->searchList($keyword);
        }

        if (isset($minPrice) || isset($maxPrice) || isset($minStock) || isset($maxStock)) {
            $minPrice = $request->input('min_price') ?: 0;
            $maxPrice = $request->input('max_price') ?: 999999;
            $minStock = $request->input('min_stock') ?: 0;
            $maxStock = $request->input('max_stock') ?: 999999;

            $search->filterByPriceAndStockRange($minPrice, $maxPrice, $minStock, $maxStock);
        }

        $products = $search->get();


        return response()->json(compact('products', 'keyword', 'companies'));
    }

}
