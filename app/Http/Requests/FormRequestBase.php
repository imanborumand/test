<?php namespace App\Http\Requests;

use App\Exceptions\CustomValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

/**
 * Class FormRequestBase
 * all FormRequest must by extend this class
 * @package App\Http\Requests
 */
abstract  class FormRequestBase extends FormRequest
{
	/**
     * generate custom response for validation response
	 * @param Validator $validator
	 * @throws CustomValidationException
	 */
	protected function failedValidation(Validator $validator)
	{
		throw new CustomValidationException(null,array_values($validator->errors()->toArray()), Response::HTTP_BAD_REQUEST,STATUS_CODE_BAD_REQUEST);
	}
}
