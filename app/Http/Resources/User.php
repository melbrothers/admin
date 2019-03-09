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
            'runner_review_statistics' => $this->runner_review_statistics,
            'sender_review_statistics' => $this->sender_review_statistics,
            'average_rating' => $this->average_rating,
            'run_tasks_count' => $this->run_tasks_count,
            'posted_tasks_count' => $this->posted_tasks_count,
            'location' => new LocationResource($this->location),
        ];
    }
}
