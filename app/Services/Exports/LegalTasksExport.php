<?php

namespace App\Services\Exports;

use Carbon\Carbon;
use App\Models\Task;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LegalTasksExport implements FromCollection, WithHeadings, WithMapping
{

    use Exportable;

    public function collection()
    {
        if(Carbon::now()->endOfMonth()){
            $legal_task = Task::with('category', 'assigned_to')
            ->select(['id', 'title', 'description','created_at', 'last_updated', 'category', 'assigned_to', 'addonstatus'])
            ->where('created_at', '>=', Carbon::now()->startOfMonth()->toDateString())
            ->where('created_at', '<=', Carbon::now()->endOfMonth()->toDateString())
            ->get();

            return $legal_task;
        } else {
            $legal_task = Task::with('category', 'assigned_to')
            ->select(['id', 'title', 'description','created_at', 'last_updated', 'category', 'assigned_to', 'addonstatus'])
            ->where('created_at', '>=', Carbon::now()->subYears(1)->toDateString())
            ->where('created_at', '<=', Carbon::now()->toDateString())
            ->get();

            return $legal_task;
        }
    }

    public function map($legal_task): array
    {
        return [
            $legal_task->id,
            $legal_task->title,
            $legal_task->description,
            Date::dateTimeToExcel($legal_task->created_at),
            Date::dateTimeToExcel($legal_task->last_updated),
            $legal_task->category->name,
            $legal_task->user->name,
            $legal_task->addonstatus->CAT,
            $legal_task->addonstatus->Agent,
            $legal_task->addonstatus->shift,
            $legal_task->addonstatus->consignee,
            $legal_task->addonstatus->refNo,
            $legal_task->addonstatus->preCaseNo, // พึ่งเพิ่มเข้ามาใหม่
            Date::dateTimeToExcel($legal_task->addonstatus->preCaseDate),
            Date::dateTimeToExcel($legal_task->addonstatus->preCaseCloseDate),
            $legal_task->addonstatus->caseNo,
            Date::dateTimeToExcel($legal_task->addonstatus->caseDate),
            Date::dateTimeToExcel($legal_task->addonstatus->caseCloseDate), // สิ้นสุด
            Date::dateTimeToExcel($legal_task->addonstatus->importDate),
            $legal_task->addonstatus->chequeNo,
            Date::dateTimeToExcel($legal_task->addonstatus->chequeDate),
            $legal_task->addonstatus->amount,
            $legal_task->addonstatus->paidby,
            $legal_task->addonstatus->chequeStatus,
            $legal_task->addonstatus->dutyChequeNo,
            Date::dateTimeToExcel($legal_task->addonstatus->dutyChequeDate),
            $legal_task->addonstatus->dutyAmount,
            $legal_task->addonstatus->dutyPaidby,
            $legal_task->addonstatus->dutyChequeStatus,
            $legal_task->addonstatus->causesOld,
            $legal_task->addonstatus->causes,
            $legal_task->addonstatus->othercause,
            $legal_task->addonstatus->oldtariff,
            $legal_task->addonstatus->newtariff,
            $legal_task->addonstatus->oldrate,
            $legal_task->addonstatus->newrate,
            $legal_task->addonstatus->investigateBy,
            $legal_task->addonstatus->remarkBy,
        ];
    }

    public function headings(): array
    {
        return [
            'Id',
            'Title/HWB',
            'Description',
            'Created Date',
            'Last Update',
            'Category',
            'Assigned To',
            'CAT',
            'ชื่อเจ้าหน้าที่',
            'กะ',
            'ชื่อลูกค้า',
            'เลขที่ใบขน',
            'เลขที่ลงรับ',
            'วันที่ลงรับ',
            'วันที่ปิดเลขของรับ',
            'เลขที่แฟ้มคดี',
            'วันที่เปิดแฟ้มคดี',
            'วันที่ปิดแฟ้มคดี',
            'วันนำเข้า',
            'เลขที่เช็คค่าปรับ',
            'วันที่เช็คค่าปรับ',
            'ยอดเงินค่าปรับ',
            'ค่าปรับชำระโดย',
            'สถานะเช็ค',
            'เลขที่เช็คค่าภาษี',
            'วันที่เช็คค่าภาษี',
            'ยอดเงินค่าภาษี',
            'ค่าภาษีจ่ายโดย',
            'สถานะเช็ค',
            'สาเหตุเก่า',
            'สาเหตุใหม่',
            'สาเหตุอื่นๆ (ถ้ามี)',
            'พิกัดเก่า (กรณีผิดพิกัด)',
            'พิกัดใหม่ (กรณีผิดพิกัด)',
            'อัตราเก่า (กรณีผิดอัตรา)',
            'อัตราใหม่ (กรณีผิดอัตรา)',
            'Investigate by',
            'Remark by'
        ];
    }
}