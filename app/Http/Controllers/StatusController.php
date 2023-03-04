<?php

namespace App\Http\Controllers;

use App\Http\Requests\Status\StoreRequest;
use App\Http\Requests\Status\UpdateRequest;
use App\Models\Status;
use Inertia\Inertia;

class StatusController extends Controller
{
    public function index()
    {
//        $statuses = Status::all();
//        return Inertia('Admin/Status', compact('statuses'));

//        оба метода работают!

        return Inertia::render('Admin/Status', [
            'statuses' => Status::all(),
        ]);
    }

    public function store (StoreRequest $request) {
        Status::create($request->validated());
    }

    public function update(UpdateRequest $request, Status $status)
    {
        $status->update($request->validated());
    }

    public function destroy(Status $status)
    {
        $status->delete();
        return redirect()->route('status.index');
    }

}
