<?php

namespace App\Http\Controllers;

use App\Http\Requests\Department\StoreRequest;
use App\Http\Requests\Department\UpdateRequest;
use App\Models\Department;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    public function index()
    {
//        $statuses = Status::all();
//        return Inertia('Admin/Status', compact('statuses'));

//        оба метода работают!

        return Inertia::render('Admin/Department', [
            'departments' => Department::all(),
        ]);
    }

    public function store (StoreRequest $request) {
        Department::firstOrCreate($request->validated());
    }

    public function update(UpdateRequest $request, Department $department)
    {
        $department->update($request->validated());
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('department.index');
    }

}
