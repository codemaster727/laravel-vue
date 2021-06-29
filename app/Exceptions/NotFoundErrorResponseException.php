<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class NotFoundErrorResponseException extends BaseErrorResponseException
{
    public function toResponse($request)
    {
        $this->setErrorMessage('リクエストが不正です。');
        $this->setStatusCode(Response::HTTP_NOT_FOUND);
        return parent::toResponse($request);
    }
}
