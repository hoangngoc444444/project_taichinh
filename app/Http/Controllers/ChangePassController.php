<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
class ChangePassController extends Controller
{
    public function admin_credential_rules(array $data)
    {
        $messages = [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'password.required' => 'Nhập mật khẩu mới',
        ];

        $validator = Validator::make($data, [
            'current_password' => 'required',
            'password' => 'required|same:password',
            'password_confirmation' => 'required|same:password',
        ], $messages);

        return $validator;
    }

    public function postCredentials(Request $request)
    {

            $request_data = $request->all();
            $validator = $this->admin_credential_rules($request_data);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }else{
                $current_password = Auth::user()->password;
                if (Hash::check($request->current_password, $current_password)) {
                    $user_id = Auth::user()->id;
                    $obj_user = User::find($user_id);
                    $obj_user->password = Hash::make($request->password);
                    $obj_user->save();
                    return redirect()->route('admin.user.index')->with('message', 'Đổi mật khẩu thành công');
                } else {
                    return redirect()->back()->with('error', 'Nhập đúng mật khẩu hiện tại');
                }
            }

    }
}
