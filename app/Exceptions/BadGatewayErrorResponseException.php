<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class BadGatewayErrorResponseException extends BaseErrorResponseException
{
    public function toResponse($request)
    {
        $this->setErrorMessage('リソースが見つかりません');
        $this->setStatusCode(Response::HTTP_NOT_FOUND);
        return parent::toResponse($request);
    }
}
