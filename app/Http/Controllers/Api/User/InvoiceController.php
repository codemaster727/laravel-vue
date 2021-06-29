<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\User\InvoiceRequest;
use App\Http\Resources\User\InvoiceResource;
use App\Http\Resources\User\InvoiceCollection;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use PDF;

class InvoiceController extends ApiBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return InvoiceResource::collection(Invoice::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceRequest $request)
    {
        // 請求書を作成する。
        $invoice = Invoice::firstOrCreate(
            $request->only('work_id', 'name', 'invoice_number', 'client_id', 'member_id', 'publish_date', 'limit_date', 'total', 'remark', 'memo', 'bill_company_name', 'bill_postal', 'bill_address', 'bill_tel', 'bill_email')
        );

        // 請求書項目を作成する。
        foreach ($request->invoice_items as $key => $item) {
            $item['invoice_id'] = $invoice->id;
            $item['total'] = $item['price'] * $item['quantity'];
            $item['sort_order'] = $key;
            InvoiceItem::create($item);
        }

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
        return new InvoiceResource(Invoice::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InvoiceRequest $request, $id)
    {
        Invoice::where('id', $id)->update(
            $request->only('name', 'invoice_number', 'publish_date', 'limit_date', 'total', 'remark', 'memo', 'status', 'client_id', 'member_id', 'bill_company_name', 'bill_postal', 'bill_address', 'bill_tel', 'bill_email')
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
        Invoice::where('id', $id)->delete();
        return response()->noContent();
    }

    public function search(Request $request)
    {
        return (new InvoiceCollection(Invoice::search($request->all())->paginate()))->response();
    }

    /**
     * Print the specified invoice.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function exportPdf($id)
    {
        $invoice = Invoice::findOrFail($id);

        view()->share('invoice', $invoice);

        $pdf = PDF::loadView('user.invoice.exportPDF');
        return $pdf->download('請求書.pdf');
    }

    /**
     * Preview the specified invoice.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function previewPdf($id)
    {
        $invoice = Invoice::findOrFail($id);

        view()->share('invoice', $invoice);

        $pdf = PDF::loadView('user.invoice.exportPDF');
        return $pdf->inline('請求書.pdf');
    }
}
