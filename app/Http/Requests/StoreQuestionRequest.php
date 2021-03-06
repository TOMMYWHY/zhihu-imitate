<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
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
            //
	        'title'=>'required|min:6|max:196',
	        'body'=>'required|min:26',
        ];
    }

	/**
	 * @return array
	 */
	public function messages() {
		 return [
			'title.required' => 'title could not be empty~!',
			'body.required' => 'body could not be empty~!'

		];
    }
}
