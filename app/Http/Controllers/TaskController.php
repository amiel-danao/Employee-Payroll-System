<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Task;
use App\Services\TaskServices;
use App\Services\ValidationServices;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;



class TaskController extends Controller
{
    protected TaskServices $taskServices;
    protected ValidationServices $validationServices;
    public function __construct()
    {
        $this->taskServices = new TaskServices;
        $this->validationServices = new ValidationServices;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::leftJoin('employees', 'tasks.employee_id', '=', 'employees.id')
            ->select([
                'tasks.id',
                'employees.name as employee_name',
                'tasks.start_date',
                'tasks.end_date',
                'tasks.status',
                'tasks.is_seen',
                'tasks.description',
                'tasks.date_taken',
                'tasks.date_completed',
            ]);


        // if (!isAdmin()) {
        //     $tasks->where('tasks.employee_id', auth()->user()->id)
        //              ->orWhere('tasks.receiver_id', auth()->user()->id);
        // }
        return Inertia::render('Task/Tasks', [
            'tasks' => $tasks->orderBy('tasks.status')
                ->paginate(config('constants.data.pagination_count')),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Task/TaskCreate', [
            'employees' => Employee::select(['id', 'name'])->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data, including the file upload
        $task = $this->validationServices->validateTaskCreationDetails($request);
        return $this->taskServices->createTask($task, $request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $loggedInUser = Auth::user();
        
        $ongoingTasksCount = Task::where('employee_id', $loggedInUser->id)
            ->where('status', 1) // Assuming 'status' is the field representing the task status
            ->count();
    
        $task = Task::with('employee')->findOrFail($id);
        return Inertia::render('Task/TaskView', [
            'task' => $task,
            'ongoingTasksCount' => $ongoingTasksCount
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $task, string $id)
    {
        $test = 0;
        $this->taskServices->updateTask($task, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Task::findOrFail($id)->delete();
        return to_route('zzz.index');
    }
}
