<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    private $role;

    public function __constructor($user, $role)
    {
        parent::__construct($user);
        $this->role = $role;
    }

    public function toArray($request)
    {
        return [
            "id" => $request->id,
            "name" => $request->name,
            "email" => $request->email,
            "score" => $request->score,
            "role" => $this->role,
        ];
    }
}
