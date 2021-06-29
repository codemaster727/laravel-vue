<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class ForbiddenErrorResponseException extends BaseErrorResponseException
{
    public function toResponse($request)
    {
        $this->setErrorMessage('アクセス権がありません。');
        $this->setStatusCode(Response::HTTP_FORBIDDEN);
        return parent::toResponse($request);
    }
}
