<?php

namespace App\Http\Controllers;

use App\Http\Requests\activateCompanyRequest;
use App\Http\Requests\addCompanyRequest;
use App\Http\Requests\getCompaniesRequest;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function getCompanies(getCompaniesRequest $request)
    {
        $companies = Company::active()->get();
        return response(['companies' => $companies], 200);
    }

    public function getAllCompanies(getCompaniesRequest $request)
    {
        $companies = Company::all();
        return response(['companies' => $companies], 200);
    }
    public function activateCompany(activateCompanyRequest $request)
    {
        $data = $request->validated();
        $company = Company::find($data['id']);
        $company->update(['status' => !$company['status']]);
        return response(['message' => 'success'], 200);
    }

    public function addCompany(addCompanyRequest $request)
    {

        $data = $request->validated();
        Company::create(['name' => $data['name'], 'logo' => $data['logo']]);
        return response(['message' => 'success'], 200);
    }
}
