<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;
use App\User;

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
            'due_date' => $this->due_date,
            'due_time' => (string) $this->due_time,
            'created_at' => $this->created_at->diffForHumans(),
            'user' => new UserResource(User::find($this->user_id))
        ];
    }
}