<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgramResource extends JsonResource
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
            'uuid' => $this->name,
            'name' => $this->slug,
            'overview' => $this->skill,
            'to_whom' => $this->skill,
            'is_access_to_author' => $this->skill,
            'content_price' => $this->skill,
            'content_description' => $this->skill,
            'chat_price' => $this->skill,
            'chat_description' => $this->skill,
            'created_at' => ($this->created_at)->format('l, F d, Y'),
        ];
    }
}
