<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Services\AttendanceServices;
use App\Services\CommonServices;
use App\Services\ValidationServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Exports\AttendanceExport;
use App\Exports\PayrollExport;
use App\Exports\LeaveExport;
use Maatwebsite\Excel\Facades\Excel;

class DownloadController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {
        

        return Inertia::render('Download/Downloads');
    }
    
    public function export_attendance()
    {
        return Excel::download(new AttendanceExport(), 'attendance.xlsx');
    }

    public function export_payroll()
    {
        return Excel::download(new PayrollExport(), 'payroll.xlsx');
    }

    public function export_absences()
    {
        return Excel::download(new LeaveExport(), 'absences.xlsx');
    }
}
