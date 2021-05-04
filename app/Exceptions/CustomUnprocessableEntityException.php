<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use App\Traits\ApiResponseTrait;


/**
 * Class CustomUnprocessableEntityException
 *
 * @package App\Exceptions
 */
class CustomUnprocessableEntityException extends Exception
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
	public function __construct(string $message = null, int $httpCode = Response::HTTP_UNPROCESSABLE_ENTITY, int $statusCode = STATUS_CODE_UNPROCESSABLE_ENTITY)
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
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function render()
	{
		return $this->unprocessableEntityResponse($this->errorMessage)
					->setHttpCode($this->errorHttpCode)
					->setStatusCode($this->errorStatusCode)
					->response();
    }

}
