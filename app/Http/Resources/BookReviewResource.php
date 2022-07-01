<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookReviewResource extends JsonResource
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
            // @TODO implement
            "id"      => $this->id,
            "review"  => $this->review,
            "comment" => $this->comment,
            "user"    => [
                "id"   => $this->user->id,
                "name" => $this->user->name,
            ],
        ];
    }
}
