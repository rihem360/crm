<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OperationResource extends JsonResource
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
            'nature_operation' => $this->nature_operation,
            'attributes' => [
                'montant_HT' => $this->montant_HT,
                'montant_TVA' => $this->montant_TVA
            ] 
        ];
    }
}
