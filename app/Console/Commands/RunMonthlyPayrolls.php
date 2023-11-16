<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\MonthlyPayrollsHandle;

class RunMonthlyPayrolls extends Command
{
    protected $signature = 'monthly-payrolls:run';
    protected $description = 'Run monthly payroll maintenance';

    public function handle()
    {
        $monthlyPayrollsHandler = new \App\Tasks\MonthlyPayrollsHandle();
        $monthlyPayrollsHandler();
    }
}
