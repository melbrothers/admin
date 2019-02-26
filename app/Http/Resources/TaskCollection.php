<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends ResourceCollection
{

   public function __construct($resource)
   {
       $this->resource = $resource;
   }

    /**
     * @inheritDoc
     */
    protected function collectResource($resource)
    {
    }


    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return ['data' => $this->collection,'meta' => 'paginate'];
    }
}
