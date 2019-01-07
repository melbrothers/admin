<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Task as TaskResource;
use App\Http\Resources\User as UserResource;
use App\Task;
use App\User;

class Bid extends JsonResource
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
            'task' => new TaskResource(Task::find($this->task_id)),
            'price' => $this->price,
            'fee' => $this->fee,
            'gst' => $this->gst,
            'comment' => $this->comment,
            'created_at' => $this->created_at->diffForHumans(),
            'user' => new UserResource(User::find($this->user_id))
        ];
    }
}