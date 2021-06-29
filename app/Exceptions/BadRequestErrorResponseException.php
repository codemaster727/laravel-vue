<?php

namespace App\Exceptions;

class BadRequestErrorResponseException extends BaseErrorResponseException
{
    public function __construct($errors = [])
    {
        $this->errors = $errors;
    }

    public function toResponse($request)
    {
        $this->setErrorMessage('リクエストが不正です。');
        $this->setStatusCode(400);
        return parent::toResponse($request);
    }
}
