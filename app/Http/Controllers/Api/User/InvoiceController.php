<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\User\InvoiceRequest;
use App\Http\Resources\User\InvoiceResource;
use App\Http\Resources\User\InvoiceCollection;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade;
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
    public function store(Request $request)
    {
        // 請求書を作成する。
        // echo "123";
        // echo $request;
        // return $request->only('work_id', 'name', 'invoice_number', 'client_id', 'member_id', 'publish_date', 'limit_date', 'total', 'remark', 'memo', 'bill_company_name', 'bill_postal', 'bill_address', 'bill_tel', 'bill_email');
        $invoice = Invoice::firstOrCreate(
            $request->only('work_id', 'name', 'invoice_number', 'client_id', 'member_id', 'publish_date', 'limit_date', 'total', 'remark', 'memo', 'bill_company_name', 'bill_postal', 'bill_address', 'bill_tel', 'bill_email')
        );
        // return $invoice;
        // 請求書項目を作成する。
        foreach ($request->invoice_items as $key => $item) {
            $item['invoice_id'] = $invoice->id;
            $item['total'] = $item['price'] * $item['quantity'];
            $item['sort_order'] = $key;
            InvoiceItem::create($item);
        }

        return response()->json(['id' => $invoice->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return Invoice::findOrFail($id);
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
        // return (new InvoiceCollection(Invoice::search($request->all())->paginate()))->response();
        return (new InvoiceCollection(Invoice::search($request->all())->where('name', 'like', "%$request->keyword%")
            ->orWhere('invoice_number', 'like', "%$request->keyword%")
            ->orWhere('remark', 'like', "%$request->keyword%")
            ->orWhere('memo', 'like', "%$request->keyword%")
            ->orderBy('created_at', 'ASC')
            ->paginate()))->response();
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
        $image = base64_encode(file_get_contents(public_path('public/background.jpg')));
        view()->share('invoice', $invoice);
        $pdf = FACADE::loadView('user.invoice.exportPDF', ['image' => $image])->setOptions(['defaultFont' => 'ipag'])->setOptions(['isRemoteEnabled' => true]);
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
        $image = base64_encode(file_get_contents(public_path('public/background.jpg')));
        view()->share('invoice', $invoice);
        $pdf = FACADE::loadView('user.invoice.exportPDF', ['image' => $image])->setOptions(['defaultFont' => 'ipag'])->setOptions(['isRemoteEnabled' => true]);
        return $pdf->stream('請求書.pdf');
    }
}
