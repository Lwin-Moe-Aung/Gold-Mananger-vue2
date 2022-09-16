<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerDataWhoHaveCreditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'contact_id' => $this->contact_id,
            'name' => $this->name,
            'mobile' => $this->mobile2 != null ? $this->mobile1 .','. $this->mobile2 : $this->mobile1,
            'address' => $this->address,
            'total_credit_money' => $this->total_credit_money,
        ];
    }
}
