<?php namespace App\Http\Requests\Api\V1;

use App\Exceptions\CustomUnAuthorizedException;
use App\Http\Requests\FormRequestBase;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetTransactionsRequest extends FormRequestBase
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => 'required|integer',
            'type' => ['required', 'string', Rule::in(TRANSACTION_TYPES)]
        ];
    }



    /**
     * @param null $keys
     * @return array

     */
    public function all($keys = null)
    {
        $data = parent::all();
        $data['type'] = strtoupper($this->query('type'));
        return $data;
    }

}
