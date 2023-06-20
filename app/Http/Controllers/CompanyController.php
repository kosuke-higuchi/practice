<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function showRegistForm() {
        // インスタンス生成
        $model  = new Company();
        $companies = $model->getlist();

        return view('regist', compact('companies'));
    }
    
}
