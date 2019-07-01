<?php

namespace App\Http\Controllers;

use App\Expend;
use App\Wallet;
use Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Exports\ExpendExport;

class ExportController extends Controller
{
    use Exportable;

    public function export($month)
    {
        $wallet = \Auth::user()->wallet;
        $id = $wallet->id;
        $expends = Expend::whereMonth('created_at', '=', date($month))->where('wallet_id', $id)->get();
        if (count($expends) > 0) {
            return Excel::download(new ExpendExport($month), 'report.xlsx');
        } else {
            return redirect()->route('admin.user.index')->with('error', "Tháng này không có giao dịch");
        }
    }
}
