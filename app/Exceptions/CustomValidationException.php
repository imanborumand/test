<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use App\Traits\ApiResponseTrait;


/**
 * Class CustomValidationException
 *
 * @package App\Exceptions
 */
class CustomValidationException extends Exception
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
	 * @var array
	 */
	public $errorArray;
	
	
	/**
	 * CustomValidationException constructor.
	 *
	 * @param string|null $message
	 * @param int         $httpCode
	 * @param int         $statusCode
	 * @param array       $errorArray
	 */public function __construct( string $message = null,  array $errorArray = [], int $httpCode = Response::HTTP_BAD_REQUEST , int $statusCode = STATUS_CODE_BAD_REQUEST)
	{
		parent::__construct($message, $httpCode);
		$this->errorMessage = $message;
		$this->errorHttpCode = $httpCode;
		$this->errorStatusCode = $statusCode;
		$this->errorArray = $errorArray;
	}
	
	
	/**
	 *
	 */
	public function report()
	{
		//
	}
	
	
	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function render()
	{
		return $this->validationErrorResponse($this->errorArray,$this->errorMessage)
					->setHttpCode($this->errorHttpCode)
					->setStatusCode($this->errorStatusCode)
					->response();
	}
}
