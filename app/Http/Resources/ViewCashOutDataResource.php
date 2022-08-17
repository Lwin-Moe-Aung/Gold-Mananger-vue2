<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ViewCashOutDataResource extends JsonResource
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
            'mobile' => $this->mobile2 != null? $this->mobile1.','.$this->mobile2 : $this->mobile1,
            'address' => $this->address,
            'invoice_no' => $this->invoice_no,
            'type' => $this->type,
            'amount' => $this->amount,
            'expense_category_name' => $this->expense_category_name,
            'created_at' => $this->created_at->toFormattedDateString()
        ];
    }
}
