<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\TransferRequest;
use App\User;
use App\Wallet;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('auth', ['only' => ['edit']]);
    }


    public function index()
    {
        return view('admin.wallet.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['user'] = Auth::user();
        return view('admin.wallet.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'Vui lòng nhập tên ví'
        ]);
        // $id = Auth::user()->id;
        $user = Auth::user();
        if (!empty($user->wallet)) {
            return redirect()->route('admin.user.index')->with('error', "Đã tồn tại ví, không thể tạo thêm");
        }
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        } else {
            $wallet = Wallet::create([
                'name' => $request->input('name'),
                'user_id' => Auth::id()
            ]);
            return redirect()->route('admin.user.index')->with('message', "Thêm ví $wallet->name thành công");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $wallet = Wallet::find($id);
        if ($wallet !== null) {
            $wallet->delete();
            return redirect()->route('admin.user.index')->with('message', "Xóa Ví $wallet->name thành công");
        }
        return redirect()->route('admin.user.index')->with('error', 'Không tìm thấy người dùng này');
    }

    public function showvalue()
    {
        $data['user'] = Auth::user();
        return view('admin.wallet.show', $data);
    }
    public function transfer(TransferRequest $request)
    {
        // Trừ đi vào tài khoản chuyển đi
        $old_wallet = Auth::user()->wallet;
        $current_money = $old_wallet->money;
        $old_wallet->money -= $request->value;
        $old_wallet->save();
        // Cộng vào tài khoản nhận vào
        $code = $request->code;
        $receiver = User::where('code', '=', $code)->first();
        $wallet = $receiver->wallet;
        $current_receiver = $wallet->money;
        $wallet->money += $request->value;
        $wallet->save();
        //tạo khoản chi
        $spending = $old_wallet->expends()->create([
            'name' => 'Chuyển tiền đến tài khoản ' . $receiver->name,
            'type' => 1,
            'wallet_id' => $old_wallet->id,
            'value' => $request->value,
            'money_after' => $old_wallet->money,
            'money_before' => $current_money
        ]);
        // tạo khoản thu
        $collect = $wallet->expends()->create([
            'name' => 'Nhận tiền từ tài khoản ' . Auth::user()->name,
            'type' => 2,
            'wallet_id' => $wallet->id,
            'value' => $request->value,
            'money_after' => $wallet->money,
            'money_before' => $current_receiver
        ]);
        return redirect()->route('admin.user.index')->with('message', "Chuyển tiền ví $old_wallet->name thành công");
    }
}
