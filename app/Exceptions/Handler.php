<?php

namespace App\Exceptions;

use App\Exceptions\ForbiddenException;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\ValidationException;
use App\Traits\MyResponseTrait;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    use MyResponseTrait;
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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ValidationException) {
            $error = $exception->getMessage();
            $error_array = $this->_customValidationMessage(json_decode($error, true));
            return $this->respondErrorValidation($error_array);
        }

        if ($exception instanceof ResourceNotFoundException) {
            return $this->respondErrorNotFound($exception->getMessage());
        }

        if ($exception instanceof ForbiddenException) {
                return $this->respondForbidden($exception->getMessage());
            }

        if ($exception instanceof GeneralException) {
            return $this->respondError($exception->getMessage());
        }

        return parent::render($request, $exception);
    }

    private function _customValidationMessage($errors){
        $data = [];

        foreach ($errors as $key => $val) {
            $data[$key] = $val[0];
        }

        return $data;
    }
}
