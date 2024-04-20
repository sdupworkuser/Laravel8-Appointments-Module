<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
