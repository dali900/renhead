<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentApprovalResource extends JsonResource
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
            'paymentable' => $this->whenLoaded('paymentable', $this->paymentable),
            'user' => $this->whenLoaded('user', UserResource::make($this->user)),
            'status' => $this->status
        ];
    }
}
