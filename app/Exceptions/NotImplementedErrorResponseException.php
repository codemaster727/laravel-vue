<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class NotImplementedErrorResponseException extends BaseErrorResponseException
{
    public function toResponse($request)
    {
        $this->setErrorMessage('サーバーエラー');
        $this->setStatusCode(Response::HTTP_NOT_IMPLEMENTED);
        return parent::toResponse($request);
    }
}
