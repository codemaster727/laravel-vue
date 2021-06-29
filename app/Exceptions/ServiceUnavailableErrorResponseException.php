<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class ServiceUnavailableErrorResponseException extends BaseErrorResponseException
{
    public function toResponse($request)
    {
        $this->setErrorMessage('サーバーエラー');
        $this->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE);
        return parent::toResponse($request);
    }
}
