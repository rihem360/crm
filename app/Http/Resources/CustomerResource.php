<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'num_tel' => $this->num_tel,
            'raison_sociale' => $this->raison_sociale,
            'location' => $this->location,
            'industry' => $this->industry,
            'aum'=>$this->aum
        ];
    }
}
