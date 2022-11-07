<?php

namespace App\Exceptions;

use App\Traits\PublicJsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{

    use PublicJsonResponse;

    protected $levels = [
        //
    ];


    protected $dontReport = [
        //
    ];


    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];


    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof NotFoundHttpException) {
            return $this->messageResponse('Not Found', 404,false);
        }

        if ($e instanceof ModelNotFoundException) {
            return $this->messageResponse('Not Found', 404,false);
        }

        if ($e instanceof HttpException) {
            return $this->messageResponse('Access Denied', 403,false);
        }

        return parent::render($request, $e);
    }
}
