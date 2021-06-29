<?php

namespace App\Http\Controllers\Api\Client;

use Auth;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\Client\ClientResource;
use App\Http\Resources\Client\ClientResourceCollection;
use App\Http\Requests\Client\ClientStoreRequest;
use App\Http\Requests\Client\ClientUpdateRequest;
use App\Http\Requests\Client\ClientMemoUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Client;

class ClientController extends ApiBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $clientList = Client::where('user_id', $user->id)->paginate();
        return (new ClientResourceCollection($clientList))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientStoreRequest $request)
    {
        $client = new Client();
        $client->user_id = Auth::user()->id;
        $client->name = $request->input('name');
        $client->tel = $request->input('tel');
        $client->memo = $request->input('memo');
        $client->save();

        return (new ClientResource($client))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return (new ClientResource($client))->response();
    }
    /**
    * Update the specified resource in storage.
    *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientUpdateRequest $request, Client $client)
    {
        $client->user_id = Auth::user()->id;
        $client->name = $request->input('name');
        $client->tel = $request->input('tel');
        $client->memo = $request->input('memo');
        $client->save();

        return (new ClientResource($client))->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    // public function destroy($id)
    {
        $client->delete();
        return response()->noContent();
        // $client = Client::find($id);
        // $client->delete();
    }

    public function updateMemo(ClientMemoUpdateRequest $request, $id)
    {
        $client = Client::find($id);
        $client->memo = $request->memo;
        $client->save();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
