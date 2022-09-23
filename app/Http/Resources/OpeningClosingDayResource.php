<?php

namespace App\Http\Resources;

// use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class OpeningClosingDayResource extends JsonResource
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
            'created_at' => $this->created_at->toFormattedDateString(),
            'opened' => $this->opened,
            'opening_balance' => $this->opening_balance,
            'opening_date_time' => Carbon::parse($this->opening_date_time)->format('g:i A'),
            'closed' => $this->closed,
            'closing_balance' => $this->closing_balance,
            'closing_date_time' => $this->closing_date_time != null ? Carbon::parse($this->closing_date_time)->format('g:i A') : null,
        ];
    }
}
