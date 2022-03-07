<?php

namespace App\Exceptions;

use App\Traits\JsonApiResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use JsonApiResponse;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Throwable $e) {
            if ($e instanceof NotFoundHttpException) {
                return $this->errorResponse(null, trans('message.http_status.not_found'), Response::HTTP_NOT_FOUND);
            }

            if ($e instanceof MethodNotAllowedHttpException) {
                return $this->errorResponse(null, $e->getMessage(), Response::HTTP_METHOD_NOT_ALLOWED);
            }

            if ($e instanceof ValidationException) {
                return $this->errorResponse($e->errors(), $e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

//            return $this->serverErrorResponse($e);
        });
    }
}
