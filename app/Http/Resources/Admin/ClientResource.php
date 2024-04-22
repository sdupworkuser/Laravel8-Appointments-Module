<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * @return array
     */    
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
