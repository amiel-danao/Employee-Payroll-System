<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Attendance::select('id', 'employee_id', 'date', 'status', 'sign_in_time', 'sign_off_time')->where('status', 'on_time')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Employee Name',
            'Employee ID',
            'Date',
            'Status',
            'Sign In Time',
            'Sign Off Time',
            // 'Notes',
            // 'Manually Filled',
            // 'Created At',
            // 'Updated At',
            // Add more columns as needed
        ];
    }
}
