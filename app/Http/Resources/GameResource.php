<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'player_a' => $this->player_a,
            'player_b' => $this->player_b,
            'winner' => $this->winner,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
