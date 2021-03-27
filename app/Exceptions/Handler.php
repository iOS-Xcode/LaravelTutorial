<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

        /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if($exception instanceof TokenExpiredException){
            return response(['error' => 'Token is expired'], RESPONSE::HTTP_UNAUTHORIZED);
        } else if ($exception instanceof TokenInvalidException){
            return response(['error' => 'Token is invalid'], RESPONSE::HTTP_UNAUTHORIZED);
        } else if ($exception instanceof JWTException){
            return response(['error' => 'Token is not provided'], RESPONSE::HTTP_UNAUTHORIZED);
        } else if ($exception instanceof TokenBlacklistedException){
            return response(['error' => 'Token can not be used, get new one'], RESPONSE::HTTP_UNAUTHORIZED);
        }


        return parent::render($request, $exception);
    }
}
