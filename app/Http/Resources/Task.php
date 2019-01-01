<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class Task extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'budget' => $this->budget,
            'location' => $this->location,
           // 'due_date' => (string) $this->due_date,
            'due_time' => (string) $this->due_time,
        ];
    }
}