<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Bid as BidResource;
use App\Http\Resources\Location as LocationResource;

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
            'slug' => $this->slug,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'deadline' => $this->deadline,
            'specified_times' => $this->specified_times,
            'location' => new LocationResource($this->location),
            'created_at' => $this->created_at,
            'sender' => new UserResource($this->sender),
            'runner' => new UserResource($this->runner),
            'state' => $this->state,
            'bids' => BidResource::collection($this->whenLoaded('bids'))
        ];
    }
}
