<?php

namespace App\Exceptions;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use RuntimeException;

class BaseErrorResponseException extends RuntimeException implements Responsable
{
    /**
     * @var string
     */
    protected $message;

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var string|null
     */
    protected $errorCode;

    /**
     * BaseErrorException constructor.
     *
     * @param string $message 簡易エラーメッセージ
     * @param int $statusCode ステータスコード
     */
    // public function __construct(string $message = '', int $statusCode = 500)
    public function __construct(string $message = '', int $statusCode = 500, $errors = [])
    {
        $this->message = $message;
        $this->statusCode = $statusCode;
        $this->errors = $errors;
    }

    /**
     * @param string $message
     */
    public function setErrorMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @param string $errorCode
     */
    public function setErrorCode(string $errorCode): void
    {
        $this->errorCode = $errorCode;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return null|string
     */
    public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }

    public function toResponse($request)
    {
        return new JsonResponse(
            $this->getBasicResponse(),
            $this->getStatusCode(),
            [],
            JSON_UNESCAPED_UNICODE
        );
    }

    protected function getBasicResponse()
    {
        return [
            'message' => $this->getErrorMessage(),
            'errors' => $this->errors,
            // 'code' => $this->getErrorCode() ?? $this->getDefaultErrorCode(),
        ];
    }

    // protected function getDefaultErrorCode(): string
    // {
    //     return $this->defaultErrorCodes[$this->getStatusCode()];
    // }
}
