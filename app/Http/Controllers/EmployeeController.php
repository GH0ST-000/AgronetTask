<?php

namespace App\Http\Controllers;
use App\Http\Requests\EmployeeValidation;
use App\Http\Resources\EmpolyeeResoource;
use App\Models\Companies;
use App\Models\employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{

    public function index()
    {
        $search = request('search',false);
        $perPage= request('per_page',10);
        $query = Employee::query();
        if ($search){
            $query->where('first_name','like',"%{$search}%")
                ->orWhere('last_name','like',"%{$search}%")
                ->orWhere('email','like',"%{$search}%")
                ->orWhere('phone','like',"%{$search}%")
                ->orWhere('companies_id','like',"%{$search}%");
        }
        return EmpolyeeResoource::collection($query->paginate($perPage));
    }



    public function store(EmployeeValidation $request)
    {
        if (Companies::exists()){
            $data = $request->validated();
            if (isset($request->companies)){
                $data['companies_id'] = (int)$request->companies;
            }else{
                $companies = Companies::first();
                $data['companies_id'] =$companies->id;
            }
            $employee = Employee::create($data);
            return new EmpolyeeResoource($employee);
        }else{
            return response()->json(['message' => ['Companies not exist']]);
        }

    }


    public function show($id)
    {
        return new EmpolyeeResoource(Employee::FindOrfail($id));
    }



    public function update(EmployeeValidation $request, $id)
    {
        $data = $request->validated();
        $id_path=Companies::Where('name',$data['companies_id'])->first();
        $data['companies_id'] = (int)$id_path->id;
        Employee::where('id',$id)->update($data);
    }


    public function destroy($id)
    {
        Employee::find($id)->delete();
        return response()->noContent();
    }
}
