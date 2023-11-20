<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Attendance::with('employee')->get()->reject(function ($attendance) {
            return $attendance->status === 'missed';
        })->map(function ($attendance) {
            return [
                'Employee Name' => $attendance->employee->name ?? '', // Fetch the employee's name
                'Employee ID' => $attendance->employee_id,                
                'Date' => $attendance->date,
                'Status' => $attendance->status,
                // Add more columns as needed
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Employee ID',
            'Employee Name',
            'Date',
            'Status',
            // Add more columns as needed
        ];
    }
}
