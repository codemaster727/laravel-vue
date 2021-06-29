<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class InternalServerErrorResponseException extends BaseErrorResponseException
{
    public function toResponse($request)
    {
        $this->setErrorMessage('サーバーエラー');
        $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        return parent::toResponse($request);
    }
}
