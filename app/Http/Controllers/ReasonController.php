<?php

namespace App\Http\Controllers;

use App\Models\ReturnReason;
use Illuminate\Http\Request;
use App\Http\Resources\ReasonResource;

class ReasonController extends Controller
{
    public function index(Request $request)
    {
        return view('reason.index');
    }

    public function store(Request $request)
    {
        $this->validate($request, ['reason' => 'required']);

        $reson = ReturnReason::create($request->all());

        if($request->ajax()){
            return response()->json(new ReturnReason($reason));
        }

        return redirect()->route('reason');
    }

    public function update($id, Request $request)
    {
        $this->validate($request, ['reason' => 'required']);

        $reason = ReturnReason::find($id);
        $reason->fill($request->all());
        $reason->save();

        if($request->ajax()){
            return response()->json(['success' => true]);
        }

        return redirect()->route('reason');
    }

    public function destroy($id)
    {
        return ReturnReason::find($id)->delete();
    }

    public function data(Request $request)
    {
        $rpp = $request->input('per_page', 20);
        $rows = new ReturnReason;
        if($request->has('sort') && $request->sort != '') {
            list($sort, $dir) = explode('|', $request->sort);
            $rows = $rows->orderBy($sort, $dir);
        }
        if($request->has('q') && $request->q != ''){
            $keyword = $request->input('q');
            $rows = $rows->where('name', 'LIKE', '%'. $keyword . '%');
        }
        $rows = $rows->paginate($rpp);
        return ReasonResource::collection($rows);
    }

    public function dropdown(Request $request)
    {
        $rows = ReturnReason::all();
        return response()->json(ReasonResource::collection($rows));
    }
}
