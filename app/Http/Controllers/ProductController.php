<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function showList(Request $request) {
        $keyword = $request->input('keyword');
        $keyword = $request->input('keyword');

        // ddd($request);
        $model = new Product();
        $products = $model->getlist();
        $model  = new Company();
        $companies = $model->getlist();

        if(!empty($keyword)) {
            $products = $model->searchList($keyword);
        }



        return view('list', compact('products', 'keyword', 'companies'));
    }

    public function registSubmit(ProductRequest $request) {
    $input = $request->all();
    DB::beginTransaction();
    try {
        $model = new Product();
        $model->registProduct($input);
        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        ddd($e);
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
        $model = new Product();
        $model->destroy($id);

        return redirect(route('list'));
    }

    public function detailEdit($id) {
        $model = new Product();
        $details = $model->whereId($id);

        $model  = new Company();
        $companies = $model->getlist();
        
        return view('edit', compact('details', 'companies'));
    }
}
