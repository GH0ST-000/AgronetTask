<?php

namespace App\Http\Resources;

use App\Models\Companies;
use Illuminate\Http\Resources\Json\JsonResource;

class EmpolyeeResoource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'companies'=>Companies::where('id',$this->companies_id)->get('name'),
            'email'=>$this->email,
            'phone'=>$this->phone
        ];
    }
}
