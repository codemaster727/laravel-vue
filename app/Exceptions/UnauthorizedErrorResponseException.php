<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class UnauthorizedErrorResponseException extends BaseErrorResponseException
{
    public function toResponse($request)
    {
        $this->setErrorMessage('アクセス権がありません');
        $this->setStatusCode(Response::HTTP_UNAUTHORIZED);
        return parent::toResponse($request);
    }
}
