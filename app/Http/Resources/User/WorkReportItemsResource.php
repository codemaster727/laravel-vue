<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class WorkReportItemsResource extends JsonResource
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
            'id'                => $this->id,
            'work_report'       => $this->workReport->title,
            'work'              => $this->work->name,
            'photo'             => $this->photo,
            'name'              => $this->name,
            'work_date'         => $this->work_date,
            'photographer'      => $this->photographer,
            'content'           => $this->content,
            'remark'            => $this->remark,
            'memo'              => $this->memo,
            'order'             => $this->order,
            'pdf'               => $this->pdf,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
            'deleted_at'        => $this->deleted_at,
        ];
    }
}
