<?php

namespace App\Http\Resources\Developers;

use Illuminate\Http\Resources\Json\JsonResource;

class DevelopersResource extends JsonResource
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
            'company' => $this->company,
            'username' => $this->username,
            'url' => $this->url,
            'repositories_count' => $this->repositories->count(),
            'repositories' => $this->repositories->groupBy('language'),
        ];
    }
}
