<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Traits\ApiResponseTrait;


/**
 * Class CustomApiException
 *
 * @package App\Exceptions
 */
class CustomApiException extends Exception
{

    use  ApiResponseTrait;

	/**
	 * @var string
	 */
	public $errorMessage;
	/**
	 * @var int
	 */
	public $errorHttpCode;
	/**
	 * @var int
	 */
	public $errorStatusCode;


	/**
	 * CustomApiException constructor.
	 *
	 * @param string|null $message
	 * @param int         $httpCode
	 * @param int         $statusCode
	 */
	public function __construct(string $message = null, int $httpCode = Response::HTTP_INTERNAL_SERVER_ERROR , int $statusCode = STATUS_CODE_INTERNAL_SERVER_ERROR)
	{
		parent::__construct($message, $httpCode);
		$this->errorMessage = $message;
		$this->errorHttpCode = $httpCode;
		$this->errorStatusCode = $statusCode;
	}


	/**
	 *
	 */
	public function report()
    {
        //
    }


	/**
	 * @return JsonResponse
	 */
	public function render()
	{
		return $this->internalErrorResponse($this->errorMessage)
					->setHttpCode($this->errorHttpCode)
					->setStatusCode($this->errorStatusCode)
					->response();
    }

}
