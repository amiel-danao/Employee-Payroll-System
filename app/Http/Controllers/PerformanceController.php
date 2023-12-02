<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Task;
use App\Services\AttendanceServices;
use App\Services\CommonServices;
use App\Services\ValidationServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Department;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;


class PerformanceController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {
        // Get tasks with associated employees and completed dat
        $tasks = Task::with('employee')
            ->whereHas('employee')
            ->whereNotNull('date_completed')
            ->get()
            ->filter(function ($task) {
                return $task->employee !== null && $task->date_completed !== null;
            });
    
        // Convert string dates to Carbon objects
        $tasks->transform(function ($task) {
            if (is_string($task->date_completed)) {
                $task->date_completed = Carbon::parse($task->date_completed)->startOfMonth();
            }
            return $task;
        });    
        // Generate an array for 12 months
        $monthsData = array_fill(0, 12, 0);
    
        // Group tasks by employee name
        $groupedTasks = $tasks->groupBy('employee.name');
    

        // fetch departments from the database
        $departments = Department::pluck('name')->toArray();
        // Fill the $monthsData array with task counts for each employee
        $result = $groupedTasks->map(function ($employeeTasks, $employeeName) use (&$monthsData) {
            $taskCount = $employeeTasks->groupBy(function ($task) {
                return $task->date_completed->format('Y-m');
            })->map->count();
    
            // Fill in $monthsData with task counts for each month
            foreach ($taskCount as $month => $count) {
                $index = (int)substr($month, 5); // Extracting month part
                $monthsData[$index - 1] += $count;
            }
    
            // Generating random colors for demonstration
            $backgroundColor = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    
            return [
                'label' => $employeeName,
                'data' => $monthsData,
                'backgroundColor' => array_fill(0, count($monthsData), $backgroundColor),
            ];
        });
    
        return Inertia::render('Performance/Performances', [
            'tasks' => $result->values()->toArray(),
            'departments' => $departments, 
        ]);
    }

    public function employee(Request $request)
    {
        $currentEmployeeId = $request->user()->id;

        $tasks = Task::with('employee')
            ->where('employee_id', $currentEmployeeId) // Filter by the current user's employee ID
            ->whereNotNull('date_completed')
            ->get()
            ->filter(function ($task) {
                return $task->employee !== null && $task->date_completed !== null;
            });
    
        // Convert string dates to Carbon objects
        $tasks->transform(function ($task) {
            if (is_string($task->date_completed)) {
                $task->date_completed = Carbon::parse($task->date_completed)->startOfMonth();
            }
            return $task;
        });    
        // Generate an array for 12 months
        $monthsData = array_fill(0, 12, 0);
    
        // Group tasks by employee name
        $groupedTasks = $tasks->groupBy('employee.name');

        // Fetch departments from the database
        $departments = Department::pluck('name')->toArray();
    
        // Fill the $monthsData array with task counts for each employee
        $result = $groupedTasks->map(function ($employeeTasks, $employeeName) use (&$monthsData) {
            $taskCount = $employeeTasks->groupBy(function ($task) {
                return $task->date_completed->format('Y-m');
            })->map->count();
    
            // Fill in $monthsData with task counts for each month
            foreach ($taskCount as $month => $count) {
                $index = (int)substr($month, 5); // Extracting month part
                $monthsData[$index - 1] += $count;
            }
    
            // Generating random colors for demonstration
            $backgroundColor = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    
            return [
                'label' => $employeeName,
                'data' => $monthsData,
                'backgroundColor' => array_fill(0, count($monthsData), $backgroundColor),
            ];
        });
    
        return Inertia::render('Performance/Performances', [
            'tasks' => $result->values()->toArray(),
            'departments' => $departments, // Pass departments to the view
        ]);
    }

}

