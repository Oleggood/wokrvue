<?php

namespace App\Http\Controllers;

use App\Http\Requests\Position\StoreRequest;
use App\Http\Requests\Position\UpdateRequest;
use App\Models\Position;
use Inertia\Inertia;

class PositionController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Position', [
            'positions' => Position::all(),
        ]);
    }

    public function store (StoreRequest $request) {
        Position::firstOrCreate($request->validated());
    }

    public function update(UpdateRequest $request, Position $position)
    {
        $position->update($request->validated());
    }

    public function destroy(Position $position)
    {
        $position->delete();
        return redirect()->route('position.index');
    }

}
