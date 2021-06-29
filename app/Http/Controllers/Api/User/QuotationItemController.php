<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\User\QuotationItemRequest;
use App\Http\Resources\User\QuotationItemResource;
use App\Models\QuotationItem;
use Illuminate\Http\Request;

class QuotationItemController extends ApiBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return QuotationItemResource::collection(QuotationItem::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        QuotationItem::create($request->all());
        return response()->noContent();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new QuotationItemResource(QuotationItem::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuotationItemRequest $request, $id)
    {
        QuotationItem::where('id', $id)->update(
            $request->only('name', 'quantity', 'unit', 'price', 'total', 'sort_order')
        );
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        QuotationItem::where('id', $id)->delete();
        return response()->noContent();
    }
}
