<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

        return redirect(route('list'));
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
}
