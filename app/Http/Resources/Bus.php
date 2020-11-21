<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Bus extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'depart_loc' => $this->depart_loc,
            'arrival_loc' => $this->arrival_loc,
            'depart_date' => $this->depart_date,
            'depart_time' => $this->depart_time,
            'arrival_time' => $this->arrival_time,
        ];
    }

    public function with($request){
        return [
            'author' => 'Aiden Perera',
            'version' => '1.0.0'
        ];
    }
}
