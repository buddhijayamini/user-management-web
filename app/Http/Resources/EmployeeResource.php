<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return
        [
            'id' => $this->id,
            'company' => new CompanyResource($this->company),
            'first name' => $this->first_name,
            'last name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'profile_image' => $this->profile_image
        ];
    }
}
