<?php

namespace App\Exports;

use App\Models\Payroll;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PayrollExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Payroll::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Employee ID',
            'Employee Name',
            'Currency',
            'Base',
            'Performance Multiplier',
            'Total Additions',
            'Total Deductions',
            'Total Payable',
            'Total Hours',
            // 'Due Date',
            // 'Is Viewed',
            // 'Status',
            // 'Created At',
            // 'Updated At',
            // Add more columns as needed
        ];
    }
}
