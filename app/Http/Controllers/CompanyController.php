<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Models\Company;

class CompanyController extends Controller
{
    public function store(StoreCompanyRequest $request)
    {
        $company = Company::create($request->all());
        return response()->json($company);
    }
}
