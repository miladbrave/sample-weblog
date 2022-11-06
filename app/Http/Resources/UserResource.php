<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    private $role;

    public function __construct($user, $role)
    {
        parent::__construct($user);
        $this->role = $role;
    }

    public function toArray($request)
    {

        $item = $this->resource;

        return [
            "id" => $item->id,
            "name" => $item->name,
            "email" => $item->email,
            "role" => $this->role,
        ];
    }
}
