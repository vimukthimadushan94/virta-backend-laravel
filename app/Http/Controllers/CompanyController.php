<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{

    /**
     * @param StoreCompanyRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *     path="/api/company",
     *     summary="Create a new company",
     *     tags={"Company"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Company data",
     *         @OA\JsonContent(
     *             required={ "name"},
     *             @OA\Property(property="parent_company_id", type="integer", example="1"),
     *             @OA\Property(property="name", type="string", example="Company A")
     *         ),
     *     ),
     *     @OA\Response(response=201, description="Company created successfully"),
     *     @OA\Response(response=400, description="Invalid data provided")
     * )
     */
    public function store(StoreCompanyRequest $request)
    {
        $company = Company::create($request->all());
        return response()->json($company,201);
    }


    /**
     * @OA\Put(
     *     path="/api/company/{id}",
     *     summary="Update an existing company",
     *     tags={"Company"},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the company to update",
     *          required=true,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Company data",
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="parent_company_id", type="integer", example="1"),
     *             @OA\Property(property="name", type="string", example="Updated Company A"),
     *         ),
     *     ),
     *     @OA\Response(response=200, description="Company updated successfully"),
     *     @OA\Response(response=400, description="Invalid data provided"),
     *     @OA\Response(response=404, description="Company not found")
     * )
     */
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

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Delete(
     *     path="/api/company/{id}",
     *     summary="Delete a company",
     *     tags={"Company"},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the company to delete",
     *          required=true,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Company deleted successfully"),
     *     @OA\Response(response=404, description="Company not found")
     * )
     */
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

    public function getAllCompanies()
    {
        return Company::all();
    }
}
