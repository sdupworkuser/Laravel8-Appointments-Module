<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
