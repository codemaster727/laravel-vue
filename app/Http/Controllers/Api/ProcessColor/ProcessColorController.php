<?php

namespace App\Http\Controllers\Api\ProcessColor;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\ProcessColor\ProcessColorResourceCollection;
use App\Models\ProcessColor;

class ProcessColorController extends ApiBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $processColors = ProcessColor::all();
        return $processColors;
        // $ProcessColorList = ProcessColor::paginate();
        // return (new ProcessColorResourceCollection($ProcessColorList))->response();
    }
}
