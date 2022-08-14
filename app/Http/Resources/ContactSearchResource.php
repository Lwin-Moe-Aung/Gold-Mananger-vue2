<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactSearchResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'mobile1' => $this->mobile1,
            'mobile2' => $this->mobile2,
            'address' => $this->address,
            'search_name' => $this->name.'( email -'.$this->email.') (ph-'.$this->mobile1.','.$this->mobile2.') (address- '.$this->address.' )',
            'created_at' => $this->created_at->toFormattedDateString()
        ];
    }
}
