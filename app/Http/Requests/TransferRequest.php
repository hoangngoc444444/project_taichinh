<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Rules\CheckEvenRule;
use App\Rules\CheckWalletRule;
class TransferRequest extends FormRequest
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
        return [
            'code' => [
                'required','numeric','exists:users',new CheckEvenRule(),new CheckWalletRule()
            ],
            'value' => 'required|numeric|max:'.$value.'|min:1',
        ];
    }
    public function messages()
    {
        return [
            'code.required' => 'Vui lòng nhập tài khoản',
            'code.numeric' => 'Số tài khoản phải là 1 số',
            'code.exists' => 'Số tài khoản không có thật',
            'code.different' => 'Số tài khoản này là của bạn',
            'value.required' => 'Vui lòng nhập số tiền',
            'value.numeric' => 'Số tiền chuyển phải là 1 số',
            'value.max' => 'Số tiền chuyển phải nhỏ hơn số tiền trong tài khoản của bạn',
            'value.min' => 'Số tiền chuyển phải lớn hơn 0',
        ];
    }
}
