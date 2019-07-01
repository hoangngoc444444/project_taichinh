<?php

namespace App\Exports;

use App\Expend;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;

class ExpendExport implements FromCollection, WithHeadings, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $month;

    public function __construct($month)
    {
        $this->month = $month;
    }
    public function collection()
    {
        $wallet = \Auth::user()->wallet;
        $id = $wallet->id;
        $month = $this->month;
        $expends = Expend::whereMonth('created_at', '=', date($month))->where('wallet_id', $id)->get();
        $stt = 1;
        foreach ($expends as $row) {
            $expend[] = array(
                '0' => $stt,
                '1' => $row->name,
                '2' => $row->type == 1 ? "chi" : "thu",
                '3' => $row->money_before,
                '4' => $row->money_after,
                '5' => $row->type == 1 ? -($row->value) : $row->value,
                '6' => $row->created_at,
                '7' => $row->updated_at,
            );
            $stt++;
        }

        return (collect($expend));
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nội dung giao dịch',
            'Loại giao dịch',
            'Số tiền trước giao dịch',
            'Số tiền sau giao dịch',
            'Giá trị giao dịch',
            'Thời gian khơi tạo giao dịch',
            'Thời gian cập nhật giao dịch',
        ];
    }
    public function registerEvents(): array
    {
        $wallet = \Auth::user()->wallet;
        $id = $wallet->id;
        $count = Expend::whereMonth('created_at', '=', date($this->month))->where('wallet_id', $id)->get()->count();
        $count += 2;
        $total = $count + 1;


        $styleArray = [
            'font' => [
                'bold' => true,
            ]
        ];
        return [
            BeforeSheet::class => function (BeforeSheet $event) use ($styleArray) {
                $event->sheet->setCellValue('A1', 'Báo cáo tháng ' . $this->month);
            },

            AfterSheet::class => function (AfterSheet $event) use ($styleArray, $count, $total) {
                $event->sheet->getStyle('A2:H2')->applyFromArray($styleArray);
                $event->sheet->getStyle('A1')->applyFromArray($styleArray);
                $event->sheet->getStyle('E' . $total)->applyFromArray($styleArray);
                $event->sheet->getStyle('F' . $total)->applyFromArray($styleArray);
                $event->sheet->setCellValue('F' . $total, '=SUM(F3:F' . $count . ')');
                $event->sheet->setCellValue('E' . $total, 'Tổng chệnh lệch thu chi tháng ' . $this->month);
            },
        ];
    }
}
