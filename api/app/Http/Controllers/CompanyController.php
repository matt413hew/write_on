<?php

namespace App\Http\Controllers;

use App\Http\Requests\getCompaniesRequest;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function getCompanies(getCompaniesRequest $request)
    {
        $companies = Company::all();
        return response(['companies' => $companies], 200);
    }
}
