<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class Company extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $fields = ['id', 'name', 'email', 'logo', 'website'];
        $data = Arr::only(parent::toArray($request), $fields);
        $data['employee_count'] = count($this->employees);

        return $data;
    }
}
