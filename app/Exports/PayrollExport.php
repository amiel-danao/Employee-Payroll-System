<?php

namespace App\Exports;

use App\Models\Payroll;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PayrollExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Payroll::with('employee')->get()->map(function ($payroll) {
            return [                
                'Employee ID' => $payroll->employee_id,
                'Employee Name' => $payroll->employee->name ?? '', // Fetch the employee's name
                'Base' => $payroll->base,
                'Total Additions' => $payroll->total_additions,
                'Total Deductions' => $payroll->total_deductions,
                'Total Payable' => $payroll->total_payable,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Employee ID',
            'Salary',
            'Additions',
            'Deductions',
            'Payable',
        ];
    }
}
