<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;
use App\Http\Resources\ShiftResource;

class ShiftController extends Controller
{
    public function index(Request $request)
    {
        return view('shift.index');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'from' => 'required',
            'to' => 'required',
            'name' => 'required',
            'day' => 'required'
        ]);

        $shift = new Shift;
        $shift->fill($request->all());
        $shift->save();

        return response()->json(['success' => true]);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'from' => 'required',
            'to' => 'required',
            'name' => 'required',
            'day' => 'required'
        ]);

        $shift = Shift::find($id);
        $shift->fill($request->all());
        $shift->save();

        return response()->json(['success' => true]);
    }

    public function data(Request $request)
    {
        $rpp = $request->input('per_page', 20);
        $rows = new Shift;
        if($request->has('sort') && $request->sort != '') {
            list($sort, $dir) = explode('|', $request->sort);
            $rows = $rows->orderBy($sort, $dir);
        }
        if($request->has('q') && $request->q != ''){
            $keyword = $request->input('q');
            $rows = $rows->where('name', 'LIKE', '%'. $keyword . '%');
        }
        $rows = $rows->paginate($rpp);
        return ShiftResource::collection($rows);
    }

    public function remove($id)
    {
        return Shift::find($id)->delete();
    }
}
