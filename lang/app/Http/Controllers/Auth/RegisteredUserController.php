<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeePosition;
use App\Models\EmployeeSalary;
use App\Models\EmployeeShift;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $now = Carbon::now();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:' . Employee::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // $employee = Employee::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        // ]);
        $year = $now->year;
        $lastEmployee = Employee::where('employee_id', 'like', $year . '%')->orderBy('employee_id', 'desc')->first();
        $employeeId = $year . '00001';

        if($lastEmployee){
            $lastId = substr($lastEmployee->id, 4);
            $employeeId = $year . str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);
        }

        $employee = Employee::factory()->create([
            'name' => $request->name,
            'email' => $request->email,
            'employee_id' => $employeeId,
            'phone' => '',
            'address' => '',
            'bank_acc_no' => '',
            'hired_on' => now()->format('Y-m-d'),
            'password' => Hash::make($request->password)
        ]);

        $employee->assignRole(Role::findByName('employee'));

        EmployeePosition::create([
            'employee_id' => $employee->id,
            'position_id' => 4,
            'start_date' => now()->format('Y-m-d'),
            'end_date' => null,
        ]);
        EmployeeShift::create([
            'employee_id' => $employee->id,
            'shift_id' => 1,
            'start_date' => now()->format('Y-m-d'),
            'end_date' => null,
        ]);

        EmployeeSalary::create([
            'employee_id' => $employee->id,
            'currency' => 'PHP',
            'salary' => fake()->numberBetween(20000, 50000),
            'start_date' => now()->format('Y-m-d'),
            'end_date' => null,
        ]);

        event(new Registered($employee));

        Auth::login($employee);

        return redirect(RouteServiceProvider::HOME);
    }
}
