<?php

namespace App\Http\Controllers\Api\Manager;

use Log;
use DateTime;
use App\Mail\MailManager;
use App\Models\Advertising;
use Illuminate\Http\Request;
use App\Models\AdvertisingTerm;
use App\Http\Requests\AdvertisingRequest;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\Manager\AdvertisingResource;
use App\Http\Resources\Manager\AdvertisingResourceCollection;

class AdvertisingController extends ApiBaseController
{
    /**
     * 一覧取得
     */
    public function index(Request $request)
    {
        return (new AdvertisingResourceCollection(Advertising::search($request->all())->get()));
    }

    /**
     * 詳細取得
     */
    public function show(Advertising $advertising)
    {
        return (new AdvertisingResource($advertising));
    }

    /**
     * 登録
     *
     * @param AdvertisingRequest $request
     * @return json
     */
    public function store(Request $request)
    {
        \DB::transaction(function () use ($request) {
            $advertising = Advertising::create($request->all());
            // 画像をアップロードしている場合、保存する
            $file = $request->file('img');
            if (isset($file)) {
                $now = time();
                $fileName = $file->getClientOriginalName();
                $ret = $file->move('uploads/advertising', $now . '_' . $fileName);
                $advertising->img_url = url('/uploads/advertising') . '/' . $now . '_' . $fileName;
            }

            $advertising->save();

            // 紐づく広告期間の更新
            $advertisingTerms = json_decode($request->advertising_terms, true);
            foreach ($advertisingTerms as $advertisingTerm) {
                $advertisingTerm['advertising_id'] = $advertising->id;
                $advertisingTerm['schedule_ended_at'] = date('Y-m-d');
                AdvertisingTerm::create($advertisingTerm);
            }

            // メール発送
            $response = 'failed';
            try {
                $ret = MailManager::send_advertising($advertising);
                if ($ret == true) {
                    $response = 'sent';
                }
            } catch(\Exception $ex) {
                Log::error($ex->getMessage());
            }

            return response()->json($response);
        });
        return response()->noContent();
    }

    /**
     * 更新
     *
     * @param AdvertisingRequest $request
     * @return json
     */
    public function update(Request $request, Advertising $advertising)
    {
        \DB::transaction(function () use ($request, $advertising) {
            // 広告の更新
            $advertising->fill($request->all());
            // 画像をアップロードしている場合、保存する
            if ($request['img']) {
                $advertising->img_url = $request['img']->store('/img/advertisings');
            }
            if ($advertising->status == 1) {
                // 停止
                $term = AdvertisingTerm::where('advertising_id', $advertising->id)->first();
                $term->ended_at = date('Y-m-d H:i:s');
                $term->save();
            }
            $advertising->save();
            // 紐づく広告期間の更新
            $advertisingTerms = $request->advertising_terms;
            if (!empty($advertisingTerms)) {
                foreach ($advertisingTerms as $advertisingTerm) {
                    \Illuminate\Support\Facades\Log::info($advertisingTerm);
                    // 削除指定がある場合は削除
                    if (isset($advertisingTerm['delelted_at'])) {
                        AdvertisingTerm::destroy($advertisingTerm['id']);
                    }
                    // IDが存在しない場合は新規登録
                    else if (!isset($advertisingTerm['id'])) {
                        AdvertisingTerm::create($advertisingTerm);
                    } else {
                        // IDが存在する場合は更新
                        AdvertisingTerm::find($advertisingTerm['id'])->fill($advertisingTerm)->save();
                    }
                }
            }
        });
        return response()->noContent();
    }

    /**
     * 削除
     *
     * @param Advertising $advertising
     * @return json
     */
    public function destroy(Advertising $advertising)
    {
        \DB::transaction(function () use ($advertising) {
            // 紐づく広告期間を削除
            $advertising->advertisingTerms()->delete();
            // 広告を削除
            $advertising->delete();
        });
        return response()->noContent();
    }

    public function confirm(Request $request) {
        $params = $request->all();

        $advertising = Advertising::find($params['advertise_id']);
        $advertising_term = AdvertisingTerm::where('advertising_id', $params['advertise_id'])->first();
        if (!isset($advertising)) {
            return response()->json(1);
        }

        if ($params['agree'] == 1) {
            // 同意する
            $today = date('Y-m-d H:i:s');
            $end_date = new DateTime($today);
            $end_date = $end_date->add(date_interval_create_from_date_string('+' . $advertising_term->period . ' months'));
            $end_date = $end_date->sub(date_interval_create_from_date_string('1 day'));
            $end_date = $end_date->format('Y-m-d H:i:s');
            $advertising_term->approve_at = $today;
            $advertising_term->started_at = $today;
            $advertising_term->schedule_ended_at = $end_date;
            $advertising_term->ended_at = $end_date;
            $advertising_term->save();

            $advertising->status = 0;
            $advertising->save();

            return response()->json(0);
        }
        else {
            // 同意しない
            $advertising->status = 1;
            $advertising->save();

            return response()->json(0);
        }
    }
}
