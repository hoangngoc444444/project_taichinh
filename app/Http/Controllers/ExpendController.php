<?php

namespace App\Http\Controllers;

use App\Expend;
use Illuminate\Http\Request;
use App\Http\Requests\ExpendRequest;
use Carbon\Carbon;

class ExpendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpendRequest $request)
    {
        $wallet = \Auth::user()->wallet;
        $current_money = $wallet->money;
        if ($request->input('type') == 1) {
            $wallet->money -= $request->value;
        } else {
            $wallet->money += $request->value;
        }
        $wallet->save();
        $expend = $wallet->expends()->create([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'value' => $request->input('value'),
            'money_after' => $wallet->money,
            'money_before' => $current_money
        ]);
        return redirect()->route('admin.wallet.index')->with('message', "Thêm giao dịch $expend->name thành công");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

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
        //
    }
}
