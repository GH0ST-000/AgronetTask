<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompaniesValidation;
use App\Http\Resources\CompaniesResource;
use App\Http\Resources\CompanyResource;
use App\Models\Companies;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class CompaniesController extends Controller
{

    public function index()
    {
        $search = request('search',false);
        $perPage= request('per_page',10);
        $query = Companies::query();
        if ($search){
            $query->where('name','like',"%{$search}%")
                ->orWhere('email','like',"%{$search}%")
                ->orWhere('website','like',"%{$search}%");
        }
        return CompaniesResource::collection($query->paginate($perPage));
    }


    public function store(CompaniesValidation $request)
    {
        $data = $request->validated();
        $image = $data['logo'] ?? false;
        if ($image){
            $relativePath = $this->saveImage($image);
            $data['logo'] = URL::to(Storage::url($relativePath));
        }
        $companies = Companies::create($data);

        return new CompaniesResource($companies);
    }


    public function show($id)
    {
        return new CompanyResource(Companies::FindOrfail($id));
    }


    public function update(CompaniesValidation $request, $id)
    {
        $old_image = Companies::Where('id',$id)->get('logo');
        $data = $request->validated();
        $image = $data['logo'] ?? end($old_image);
        if ($image) {
            $relativePath = $this->saveImage($image);
            $data['logo'] = URL::to(Storage::url($relativePath));
        }
        Companies::where('id',$id)->update($data);
    }


    public function destroy($id)
    {
        Companies::find($id)->delete();
        return response()->noContent();
    }



    private function saveImage(mixed $image)
    {
        $path = 'images/' . Str::random();
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path, 0755, true);
        }
        if (!Storage::putFileAS('public/' . $path, $image, $image->getClientOriginalName())) {
            throw new \Exception("Unable to save file \"{$image->getClientOriginalName()}\"");
        }

        return $path . '/' . $image->getClientOriginalName();
    }
}
