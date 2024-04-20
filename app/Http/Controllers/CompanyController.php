<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteCompanyRequest;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CompanyController extends Controller
{
    public function store(StoreCompanyRequest $request)
    {
        $company = Company::create($request->all());
        return response()->json($company);
    }

    public function update(UpdateCompanyRequest $request, $id)
    {
        try {
            $company = Company::findOrFail($id);
            $company->update($request->all());
            return response()->json($company);
        }catch (ModelNotFoundException $exception){
            return response()->json(['error' => 'Company not found'], 404);
        }

    }

    public function delete($id)
    {
        try {
            $company = Company::findOrFail($id);
            $company->delete();
            return response()->json($company);
        }catch (ModelNotFoundException $exception){
            return response()->json(['error' => 'Company not found'], 404);
        }
    }
}
