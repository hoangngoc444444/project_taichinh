<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Wallet;
use App\Expend;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($wallet = \Auth::user()->wallet) {
            $id = $wallet->id;
            // $last = Expend::where('wallet_id', $id)->max('created_at');
            $begin = Expend::where('wallet_id', $id)->min('created_at');
            $now = Carbon::now();
            $dt = Carbon::create($begin);
            // $month_now = $now->month;
            // $month_dt = $dt->month;
            $month = $now->diffInMonths($dt);
            // dd($month);
// echo (($diff->format('%y') * 12) + $diff->format('%m')) . " full months difference";
            // $month = $month_now - $month_dt + 1;
            // $data['month'] = $month;
            // $data['start'] = $month_dt;
            // // $month = $month > 1 ? $month : 2;
            $date1 = Carbon::createMidnightDate(2019, 1, 1);
$date2 = Carbon::createMidnightDate(2019, 7, 9);
dd($date1->diffInMonths($date2));

            $firstDate = new \DateTime($now);
$secondDate  = new \DateTime($dt);
$interval = date_diff($firstDate, $secondDate);

$month = $interval->format('%y')*12+$interval->format('%m') . " months";
$data['month'] = $month;
$data['start'] = $month_dt;
        }

        $id = Auth::user()->id;
        $data['user'] = User::find($id);
        return view('admin.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['user'] = User::find($id);
        if ($data['user'] !== null) {
            return view('admin.user.show', $data);
        }
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
    public function update(EditUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user !== null) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->birthday = $request->birthday;
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                $fileName = $images->getClientOriginalName();

                $images->move(public_path('uploads'), $fileName);
                $user->images = $fileName;
            }
            $user->save();
            return redirect()->route('admin.user.index')->with('message', "Sửa tài khoản $user->name thành công");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
