<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkReportResource extends JsonResource
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
            'id'					=> $this->id,
            'work'					=> $this->work->name,
            'title'					=> $this->title,
            'logo'					=> $this->logo,
            'created_at'			=> $this->created_at,
            'updated_at'			=> $this->updated_at,
            'deleted_at'			=> $this->deleted_at,
        ];
    }
}
