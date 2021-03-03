<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'application' => $this->application,
            'language' => [
                'name' => $this->language->name,
                'locale' => $this->language->locale,
            ],
            'os' => $this->operatingSystem->name,
        ];
    }
}
