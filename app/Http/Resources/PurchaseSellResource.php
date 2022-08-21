<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseSellResource extends JsonResource
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
            'transaction_id' => $this->transaction_id,
            'contact_name' => $this->contact_name.'( email -'.$this->email.') (ph-'.$this->mobile1.','.$this->mobile2.') (address- '.$this->address.' )',
            'image' => $this->image,
            'item_name' => $this->item_name,
            'item_sku' => $this->item_sku,
            'product_sku' => $this->product_sku,
            'invoice_no' => $this->invoice_no,
            'final_total' => $this->final_total,
            'created_at' => $this->created_at->toFormattedDateString()
        ];
    }
}
