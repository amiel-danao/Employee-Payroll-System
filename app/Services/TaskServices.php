<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Mail\RequestStatusUpdated;
use Arr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Illuminate\Http\Request;

class TaskServices
{
    public function createTask($task, $request): \Illuminate\Http\RedirectResponse
    {
        $task['start_date'] = $task['due_date'][0];
        $task['end_date'] = $task['due_date'][1];
        $task = Arr::except($task, ['due_date']);        
        // Process the file upload and save the file
        // $file = $request->file('task_file');
        // $fileName = $file->getClientOriginalName();
        // $file->storeAs('public/tasks', $fileName);
        // $request['file_path'] = 'storage/tasks/' . $fileName;

        \App\Models\Task::create($task);

        return to_route('zzz.index');
    }
    public function updateTask(Request $request, $id)
    {
        $taskData = $request->validate([
            'status' => ['required', 'integer', 'in:1,2,3,4'],
            'file_path' => ['nullable', 'file'], // Add validation for file_path if necessary
            // 'admin_response' => ['nullable', 'string'],
        ]);


        
        $empTask = \App\Models\Task::findOrFail($id);

        if($empTask->employee == null){
            $taskData['employee_id'] = $request->user()->id;
        }

        // Check if file_path exists in the request and is not empty
        if ($request->hasFile('file_path')) {
            // Call the uploadFile function passing the file path
            $taskData['file_path'] = $this->uploadFile($request->file('file_path'));
        }

        // Update the specific columns based on the status
        if ($taskData['status'] == 2) {
            $taskData['date_completed'] = now();
        } elseif ($taskData['status'] == 1) {
            $taskData['date_taken'] = now();
        }
        
        $empTask->update($taskData);
    }


    public function validateTaskCreationDetails(Request $request)
    {
        return $request->validate([
            'employee_id' => 'required|integer|exists:employees,id',
            'description' => 'required|string|max:255',
            'due_date' => 'required|date',
            'file_path' => 'required|file|mimes:pdf,docx,doc|max:2048',
        ]);
    }


    public function uploadFile($file)
    {
        $fileName = time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('tasks'), $fileName); // Store in 'public/tasks'
    
        return $fileName;
    }
    



    public function deleteFile($fileName)
    {
        Storage::delete('public/tasks/' . $fileName);
    }
    
}
