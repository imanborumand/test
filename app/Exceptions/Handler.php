<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
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


    protected array $httpCodes = [
        200,
        201,
        404,
        500,
        401,
        405,
        403,
        400,
        422,
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $exception) {

            $className = str_replace('"', "", get_class($exception));
            if($this->isHttpException($exception) || !(isset($className) && substr($className,0,14) == CUSTOM_EXCEPTIONS_PATH)) {
                $httpCode = $this->getResponseHttpCode($exception);
                $statusCode = $this->getStatusCode($httpCode);

                throw  new  CustomApiException($exception->getMessage(),$httpCode,$statusCode);
            }
        });
    }


    /**
     * @param $e
     * @return bool|int
     */
    private function getResponseHttpCode( $e)
    {

        $exceptionCode = $e->getCode();
        $notHttpExceptionCode = $this->checkException($e);

        if($notHttpExceptionCode){
            return $notHttpExceptionCode;
        }

        if($this->isHttpException($e) && $e->getStatusCode() != 0 && in_array($e->getStatusCode(),$this->httpCodes) ) {
            return $e->getStatusCode();

        }elseif(isset($exceptionCode) && $exceptionCode != 0  && in_array($exceptionCode,$this->httpCodes)) {
            return $exceptionCode;
        }
        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }


    /**
     * @param $httpCode
     * @return int
     */
    private function getStatusCode($httpCode) : int
    {
        $mapping = [
            '200' =>   STATUS_CODE_OK,
            '201' =>   STATUS_CODE_CREATED,
            '404' =>   STATUS_CODE_NOT_FOUND,
            '500' =>   STATUS_CODE_INTERNAL_SERVER_ERROR,
            '401' =>   STATUS_CODE_UNAUTHENTICATED,
            '405' =>   STATUS_CODE_METHOD_NOT_ALLOWED,
            '403' =>   STATUS_CODE_FORBIDDEN,
            '400' =>   STATUS_CODE_BAD_REQUEST,
            '422' =>   STATUS_CODE_UNPROCESSABLE_ENTITY,
        ];

        return  $mapping[$httpCode] ?? STATUS_CODE_INTERNAL_SERVER_ERROR;
    }


    /**
     * @param $e
     * @return bool|int
     */
    private function checkException($e)
    {
        if ($e instanceof AuthenticationException) {
            return 401;
        }
        return  false;
    }
}
