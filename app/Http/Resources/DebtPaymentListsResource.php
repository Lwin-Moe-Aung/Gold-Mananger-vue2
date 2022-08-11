<?php

namespace App\Http\Resources;

// use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;


class DebtPaymentListsResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->contact->name,
            'mobile' => $this->contact->mobile2 != null? $this->contact->mobile1.','.$this->contact->mobile2 : $this->contact->mobile1,
            'debt_paid_money' => $this->debt_paid_money,
            'remaining_credit_money' => $this->remaining_credit_money,
            'created_at' => $this->created_at->toFormattedDateString()
        ];
    }
}
