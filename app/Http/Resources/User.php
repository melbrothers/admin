<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Task as TaskResource;
use App\Http\Resources\Location as LocationResource;

class User extends JsonResource
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
            'name' => $this->name,
            'avatar' => $this->avatar,
            'locale' => $this->locale,
            'created_at' => $this->created_at,
            'tasks' => TaskResource::collection($this->whenLoaded('tasks')),
            'location' => new LocationResource($this->location),
        ];
    }
}
