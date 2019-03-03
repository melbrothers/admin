<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Comment as CommentResource;

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
            'task_id' => $this->task_id,
            'comments' => CommentResource::collection($this->comments),
            'price' => $this->price,
            'created_at' => $this->created_at,
            'runner' => new UserResource($this->runner),
            'accepted' => $this->accepted
        ];
    }
}
