<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductReturn;
use App\Models\InventoryReport;
use App\Http\Resources\ProductReturnResource;

class ProductReturnController extends Controller
{
    public function index()
    {
        return view('ng.index');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'report_id' => 'required',
            'reason' => 'required',
            'qty' => 'required'
        ]);

        $report = InventoryReport::find($request->report_id);
        $report->returns()->create(['reason' => $request->reason, 'qty' => $request->qty]);

        return response()->json(['success' => true]);
    }

    public function destory($id)
    {
        return ProductReturn::find($id)->delete();
    }

    public function data(Request $request)
    {
        $rpp = $request->input('per_page', 20);
        $rows = ProductReturn::where('inventory_report_id', $request->inventory_report_id);

        if($request->has('sort') && $request->sort != '') {
            list($sort, $dir) = explode('|', $request->sort);
            $rows = $rows->orderBy($sort, $dir);
        }
        if($request->has('q') && $request->q != ''){
            $keyword = $request->input('q');
            $rows = $rows->where('name', 'LIKE', '%'. $keyword . '%');
        }
        $rows = $rows->paginate($rpp);

        return ProductReturnResource::collection($rows);
    }
}
