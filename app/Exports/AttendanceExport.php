<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Attendance::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Employee ID',
            'Date',
            'Status',
            'Sign In Time',
            'Sign Off Time',
            'Notes',
            'Manually Filled',
            'Created At',
            'Updated At',
            // Add more columns as needed
        ];
    }
}
