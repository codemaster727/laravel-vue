<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class DiagnoseReportItemResource extends JsonResource
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
            'diagnose_report_id' => $this->diagnose_report_id,
            'diagnose_report' => $this->diagnoseReport->title,
            'photo' => $this->photo,
            'name' => $this->name,
            'content' => $this->content,
            'sort_order' => $this->sort_order
        ];
    }
}
