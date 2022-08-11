<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
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
            'type_doc' => $this->type_doc,
            'client_id' => $this->client_id,
            'attributes' => [
                'info_supp' => $this->info_supp,
                'etat' => $this->etat,
                'montant_HT' => $this->montant_HT,
                'created_at' => $this->created_at
            ] 
        ];
    }
}
