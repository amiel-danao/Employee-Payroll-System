<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeaveExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Attendance::where('status', 'missed')
            ->with('employee') // Load the related employee data
            ->get()
            ->map(function ($attendance) {
                return [                    
                    'Employee Name' => $attendance->employee->name, // Fetch the employee's name
                    'Employee ID' => $attendance->employee_id,
                    'Date' => $attendance->date,
                    'Notes' => $attendance->notes
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Employee ID',            
            'Date',            
            'Reason'
            // Add more columns as needed
        ];
    }
}
