<?php

namespace App\Http\Controllers;

use App\Http\Requests\Status\StoreRequest;
use App\Http\Requests\Status\UpdateRequest;
use App\Models\Role;
use App\Models\Status;
use Inertia\Inertia;

class StatusController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Status', [
            'statuses' => Status::all(),
            'roles' => Role::all(),
        ]);
    }

//    public function store (StoreRequest $request) {
//        Status::firstOrCreate($request->validated());
//    }
//
//    public function update(UpdateRequest $request, Status $status)
//    {
//        $status->update($request->validated());
//    }
//
//    public function destroy(Status $status)
//    {
//        $status->delete();
//        return redirect()->route('status.index');
//    }

}
