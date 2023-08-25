<?php

namespace App\Http\Controllers\settings;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class SettingOrganizationCompanyController extends Controller
{
    public function index()
    {
        $company = Company::first();
         return view('setting.organization.company.index',[
            'company' => $company
        ]);
    }
    public function update(Request $request)
    {
        $validator = $this->validateFormData($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $companyId = $request->id;
        $name = $request->name;
        $address = $request->address; 
        $phone = $request->phone; 
        $fax = $request->fax; 
        $tax = $request->tax; 
       
        Company::find($companyId)->update([
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
            'fax' => $fax,
            'tax' => $tax,
        ]);
        return redirect()->back();
    }

    function validateFormData($request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
                'name' => 'required',
                'address' => 'required',
                'phone' => 'required',
                'tax' => 'required|numeric|digits:13'
            ]);
        return $validator;
    }
}
