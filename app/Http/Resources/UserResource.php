<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Disable data wrap
     */
    public static $wrap = null;
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this['id'],
            'username' => $this['username'],
            'email' => $this['email'],
            'updated_at' => $this['updated_at'],
            'created_at' => $this['created_at']
        ];
    }
}
