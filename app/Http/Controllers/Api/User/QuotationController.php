<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\User\QuotationRequest;
use App\Http\Resources\User\QuotationResource;
use App\Http\Resources\User\QuotationCollection;
use Illuminate\Http\Request;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Invoice;
use PDF;


class QuotationController extends ApiBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return QuotationResource::collection(Quotation::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 見積書を作成する。
        $request_only = $request->only('work_id', 'name', 'number', 'client_id', 'member_id', 'publish_date', 'expiration_date', 'total', 'remark', 'memo');
        $quotation = Quotation::firstOrNew(
            $request_only
        );
        // var_dump($quotation);exit;

        // 見積書項目を作成する。
        foreach ($request->quotation_items as $key => $item) {
            $item['quotation_id'] = $quotation->id;
            $item['total'] = $item['price'] * $item['quantity'];
            $item['sort_order'] = $key;
            QuotationItem::create($item);
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
        return new QuotationResource(Quotation::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuotationRequest $request, $id)
    {
        Quotation::where('id', $id)->update(
            $request->only('name', 'number', 'publish_date', 'expiration_date', 'total', 'remark', 'memo', 'status', 'client_id', 'member_id', 'bill_company_name', 'bill_postal', 'bill_address', 'bill_tel', 'bill_email')
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
        Quotation::where('id', $id)->delete();
        return response()->noContent();
    }

    public function search(Request $request)
    {
        // return (new QuotationCollection(Quotation::search($request->all())->paginate()))->response();
        return (new QuotationCollection(Quotation::search($request->all())->where('name', 'like', "%$request->keyword%")
            ->orWhere('number', 'like', "%$request->keyword%")
            ->orWhere('memo', 'like', "%$request->keyword%")
            ->orderBy('created_at', 'ASC')
            ->paginate()))->response();
    }

    /**
     * Print the specified quotation.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function exportPdf($id)
    {
        $quotation = Quotation::findOrFail($id);

        view()->share('quotation', $quotation);

        $pdf = PDF::loadView('user.quotation.exportPDF');
        return $pdf->download('見積書.pdf');
    }

    /**
     * Preview the specified quotation.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function previewPdf($id)
    {
        $quotation = Quotation::findOrFail($id);

        view()->share('quotation', $quotation);

        $pdf = PDF::loadView('user.quotation.exportPDF');
        return $pdf->inline('見積書.pdf');
    }

    /**
     * 請求書を作成・変更する
     *
     * @param int $id
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function createOrUpdateInvoice($id)
    {
        $quotation = Quotation::with('quotationItems')->findOrFail($id);

        // 請求書を作成・変更する。
        $invoice = Invoice::firstOrNew(['quotation_id' => $id],
            array(
                'work_id' => $quotation->work_id,
                'name' => $quotation->name,
                'invoice_number' => $quotation->number,
                'client_id' => $quotation->client_id,
                'member_id' => $quotation->member_id,
                'publish_date' => $quotation->publish_date,
                'limit_date' => $quotation->expiration_date,
                'total' => $quotation->total,
                'remark' => $quotation->remark,
                'memo' => $quotation->memo,
            )
        );
        $quotation->invoice_id = $invoice->id;

        // 請求書項目を作成・変更する。
        $invoice->invoiceItems()->delete();
        foreach ($quotation->quotationItems() as $item) {
            $item['invoice_id'] = $invoice->id;
            $item['limit_date'] = $item['expiration_date'];
            unset($item['quotation_id']);
            unset($item['created_at']);
            unset($item['updated_at']);
            unset($item['deleted_at']);
            unset($item['id']);
            unset($item['expiration_date']);
            $invoice->invoiceItems()->insert($item);
        }

        // 見積書を確定する。
        $quotation->status = 1;
        $quotation->save();

        return response()->noContent();
    }
}
