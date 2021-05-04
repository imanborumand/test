<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Traits\ApiResponseTrait;

/**
 * Class CustomNotFoundException
 *
 * @package App\Exceptions
 */
class CustomNotFoundException extends Exception
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
	 * CustomNotFoundException constructor.
	 *
	 * @param string|null $message
	 * @param int         $httpCode
	 * @param int         $statusCode
	 */public function __construct( string $message = null, int $httpCode = Response::HTTP_NOT_FOUND , int $statusCode = STATUS_CODE_NOT_FOUND)
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
		return $this->notFoundResponse($this->errorMessage)
					->setHttpCode($this->errorHttpCode)
					->setStatusCode($this->errorStatusCode)
					->response();
    }

}
