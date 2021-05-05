<?php namespace App\Traits;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;


/**
 * Trait ApiResponseTrait
 * this trait is in charge create json response for all api response
 * @package App\CustomStuff\Traits
 */
trait ApiResponseTrait
{
	/**
	 * @var array
	 */
	protected $data       = [];
	/**
	 * @var string
	 */
	protected string $responseMessage = ""; // custom message
	/**
	 * @var bool
	 */
	protected bool $status     = true; // false or true
	/**
	 * @var int
	 */
	protected  int $httpCode   = Response::HTTP_OK; // http code example 400, 401, 200
	/**
	 * @var int
	 */
	protected int $statusCode = STATUS_CODE_OK; // one number code big then 1000
	/**
	 * @var array
	 */
	protected array $result = [];
	/**
	 * @var array
	 */
	protected array $errors = [];

    protected array $paginate = [];


    public function setData($data = [])
    {

        /*
         * check if data is object change to array and check for isset paginate
         * remove default laravel paginate key and create customize paginate
         */
        if (! is_array($data)) {

            $dataArray = collect($data)->toArray();
            if (isset($dataArray['current_page'])) {
                $this->paginate = [
                    'total' => $dataArray['total'],
                    'per_page' => $dataArray['per_page'],
                    'current_page' => $dataArray['current_page'],
                    'next_page_url' => $dataArray['next_page_url'],
                    'last_page_url' => $dataArray['last_page_url'],
                    'prev_page_url' => $dataArray['prev_page_url'],
                    'first_page_url' => $dataArray['first_page_url'],
                    'last_page' => $dataArray['last_page'],

                ];
                //remove default laravel paginate key and merge new paginate
                $data = array_merge([], array_diff_key($dataArray, array_fill_keys([
                    'current_page',
                    'first_page_url',
                    'from',
                    'last_page',
                    'last_page_url',
                    'next_page_url',
                    'path',
                    'per_page',
                    'prev_page_url',
                    'to',
                    'total'
               ], null)));
                $data = $data['data'];
            }
        }


        $this->data = $data;
        return $this;
    }


    /**
	 * @return array
	 */
	public function getData()
	{
		return $this->data;
	}


	/**
	 * @param string $responseMessage
	 * @return $this
	 */
	public function setResponseMessage(string $responseMessage)
	{
	    if($responseMessage != '') {
            $this->responseMessage = $responseMessage;
        }

		return $this;
	}


	/**
	 * @return null
	 */
	public function getResponseMessage()
	{
		return $this->responseMessage;
	}


	/**
	 * @param $status
	 * @return $this
	 */
	public function setStatus($status)
	{
		$this->status = $status;
		return $this;
	}


	/**
	 * @return bool
	 */
	public function getStatus()
	{
		return $this->status;
	}


	/**
	 * @param int $httpCode
	 * @return $this
	 */
	public function setHttpCode( int $httpCode)
	{
		$this->httpCode = $httpCode;
		return $this;
	}


	/**
	 * @return int
	 */
	public function getHttpCode()
	{
		return $this->httpCode;
	}


	/**
	 * @param int $statusCode
	 * @return $this
	 */
	public function setStatusCode(int $statusCode)
	{
		$this->statusCode = $statusCode;
		return $this;
	}


	/**
	 * @return int
	 */
	public function getStatusCode()
	{
		return $this->statusCode;
	}


	/**
	 * @param array $errors
	 * @return $this
	 */
	public function setErrors($errors = [])
	{
		$this->errors = $errors;
		return $this;
	}


	/**
	 * @return array
	 */
	public function getErrors()
	{
		return $this->errors;
	}


	/**
	 * @param string $message
	 * @param int    $statusCode
	 * @param int    $httpCode
	 * @param bool   $status
	 * @return $this
	 */
	public function setParams(string  $message, int $statusCode, int $httpCode, bool $status)
	{
		$this->setStatusCode($statusCode)
			 ->setHttpCode($httpCode)
			 ->setResponseMessage($message)
			 ->setStatus($status);
		return $this;
	}


	/**
	 * @return $this
	 */
	public function setResult()
	{
		$this->result['data']        = $this->getData();
		$this->result["message"]     = $this->getResponseMessage();
		$this->result["status"]    	 = $this->getStatus();
		$this->result["status_code"] = $this->getStatusCode();
		$this->result['errors']      = $this->getErrors();
        $this->result['paginate']    = $this->paginate;
		return $this;
	}


	/**
	 * @return array
	 */
	public function getResult()
	{
		return $this->result;
	}


	/**
	 * @return JsonResponse
	 */
	public function response() : JsonResponse
	{
		$this->setResult();
		return response()->json($this->getResponseData($this->getResult()), $this->getHttpCode());
	}


	/**
	 * @param string|null $message
	 * @return $this
	 */
	public function successResponse(string $message = null)
    {
		$message = $message ?? 'success!';
		$this->setParams($message,STATUS_CODE_OK,Response::HTTP_OK,true);
		return $this;
	}


	/**
	 * @param string|null $message
	 * @return $this
	 */
	public function createdResponse(string $message = null)
    {
		$message = $message ?? 'item created';
		$this->setParams($message,STATUS_CODE_CREATED,Response::HTTP_CREATED,true);
		return $this;
	}


	/**
	 * @param string|null $message
	 * @return $this
	 */
	public function notFoundResponse(string $message = null)
    {
		$message = $message ?? 'not Found!';
		$this->setParams($message,STATUS_CODE_NOT_FOUND,Response::HTTP_NOT_FOUND,false);
		return $this;
	}


	/**
	 * @param string|null $message
	 * @return $this
	 */
	public function  failedResponse(string $message = null)
    {
		$message = $message ?? 'failed Response';
		$this->setParams($message,STATUS_CODE_INTERNAL_SERVER_ERROR,Response::HTTP_INTERNAL_SERVER_ERROR,false);
		return $this;
	}


	/**
	 * @param string|null $message
	 * @return $this
	 */
	public function internalErrorResponse(string $message = null)
    {
		$message = $message ?? 'internal Error' ;
		$this->setParams($message,STATUS_CODE_INTERNAL_SERVER_ERROR,Response::HTTP_INTERNAL_SERVER_ERROR,false);
		return $this;
	}

	/**
	 * @param string|null $message
	 * @return $this
	 */
	public function queryErrorResponse(string $message = null)
	{
		$message = $message ?? 'query Error ';
		$this->setParams($message,STATUS_CODE_INTERNAL_SERVER_ERROR,Response::HTTP_INTERNAL_SERVER_ERROR,false);
		return $this;
	}


	/**
	 * @param string|null $message
	 * @return $this
	 */
	public function notAuthenticatedResponse(string $message = null)
    {
		$message = $message ?? 'not Authenticated';
		$this->setParams($message,STATUS_CODE_UNAUTHENTICATED,Response::HTTP_UNAUTHORIZED ,false);
		return $this;
	}


	/**
	 * @param string|null $message
	 * @return $this
	 */
	public function methodNotAllowedHttpException(string $message = null)
    {
		$message = $message ?? 'method Not Allowed';
		$this->setParams($message,STATUS_CODE_METHOD_NOT_ALLOWED,Response::HTTP_METHOD_NOT_ALLOWED,false);
		return $this;
	}


	/**
	 * @param string|null $message
	 * @return $this
	 */
	public function notAuthorizedResponse(string $message = null)
    {
		$message = $message ?? 'not Authorized Response';
		$this->setParams($message,STATUS_CODE_FORBIDDEN, Response::HTTP_FORBIDDEN,false);
		return $this;
	}


	/**
	 * @param string|null $message
	 * @return $this
	 */
	public function badRequestResponse(string $message = null)
    {
		$message = $message ?? 'error bad request!';
		$this->setParams($message,STATUS_CODE_BAD_REQUEST,Response::HTTP_BAD_REQUEST,false);
		return $this;
	}

	/**
	 * @param string|null $message
	 * @return $this
	 */
	public function unprocessableEntityResponse(string $message = null)
    {
		$message = $message ?? 'unprocessable Entity Response!';
		$this->setParams($message,STATUS_CODE_UNPROCESSABLE_ENTITY,Response::HTTP_UNPROCESSABLE_ENTITY,false);
		return $this;
	}

	/**
	 * @param array $errors
	 * @param null  $message
	 * @return $this
	 */
	public function validationErrorResponse(array $errors, $message = null)
    {
		$message = $message ?? 'validation Error Response';
		$this->setErrors($errors);
		$this->setParams($message,STATUS_CODE_BAD_REQUEST,Response::HTTP_BAD_REQUEST ,false);
		return $this;
	}


	/**
	 * @param             $data
	 * @param bool        $status
	 * @param int         $statusCode
	 * @param int         $httpCode
	 * @param string|null $message
	 * @param array       $errors
	 * @return $this
	 */
	public function customResponse($data, bool $status = true, int $statusCode = STATUS_CODE_OK, int $httpCode = Response::HTTP_OK, string $message =null, array $errors = [])
	{
		$message = $message ?? "custom Response";
		$this->setData($data);
		$this->setErrors($errors);
		$this->setParams($message,$statusCode,$httpCode,$status);
		return $this;
	}


	/**
	 * @param array $result
	 * @return array
	 */
	private function getResponseData(array $result) : array
	{
		if(isset($result['data']['message']) &&
		   isset($result['data']['status'])  &&
		   isset($result['data']['errors'])  &&
		   isset($result['data']['status_code']) &&
		   isset($result['data']['data'])){

			return $result['data'];

		}else{
			$result['data'] = $result['data'] ?? [];
			return $result ;
		}
	}

}
