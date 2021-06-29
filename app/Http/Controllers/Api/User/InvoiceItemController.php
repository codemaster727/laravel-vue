<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\User\InvoiceItemRequest;
use App\Http\Resources\User\InvoiceItemResource;
use App\Models\InvoiceItem;

class InvoiceItemController extends ApiBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return InvoiceItemResource::collection(InvoiceItem::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceItemRequest $request)
    {
        InvoiceItem::create($request->all());
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
        return new InvoiceItemResource(InvoiceItem::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InvoiceItemRequest $request, $id)
    {
        InvoiceItem::where('id', $id)->update(
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
        InvoiceItem::where('id', $id)->delete();
        return response()->noContent();
    }
}
