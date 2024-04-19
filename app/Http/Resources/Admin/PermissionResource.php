<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    /**
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
