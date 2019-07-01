<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class ExpendRequest extends FormRequest
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
        $value = Auth::user()->wallet->money;
        $rules = [
            'name' => 'required',
            'type' => 'required',
            'value' => 'required|numeric|max:'.$value.'|min:1',
        ];
        if ($this->input('type') == 2) {
            $rules['value'] = 'required|numeric|min:1';
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập nội dung thu chi',
            'type.required' => 'Vui lòng chọn loại thu chi',
            'value.required' => 'Vui lòng nhập số tiền',
            'value.numeric' => 'Số tiền chuyển phải là 1 số',
            'value.max' => 'Số tiền chi ra phải nhỏ hơn số tiền trong tài khoản của bạn',
            'value.min' => 'Số tiền thu chi phải lớn hơn 0',
        ];
    }
}
