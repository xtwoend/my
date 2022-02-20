<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Resources\LocationResource;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        return view('location.index');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'gln' => 'required',
            'name' => 'required'
        ]);

        $location = Location::whereGln($request->gln)->first();
        if(! $location){
            $location = new Location;
        }

        $location->fill($request->all());
        $location->save();

        if($request->ajax()){
            return response()->json(['success' => true]);
        }

        return redirect()->route('location');
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'gln' => 'required',
            'name' => 'required'
        ]);

        $location = Location::find($id);
        $location->fill($request->all());
        $location->save();

        if($request->ajax()){
            return response()->json(['success' => true]);
        }
    }

    public function remove($id)
    {
        return Location::find($id)->delete();
    }

    public function data(Request $request)
    {
        $rpp = $request->input('per_page', 20);
        $rows = new Location;
        if($request->has('sort') && $request->sort != '') {
            list($sort, $dir) = explode('|', $request->sort);
            $rows = $rows->orderBy($sort, $dir);
        }
        if($request->has('q') && $request->q != ''){
            $keyword = $request->input('q');
            $rows = $rows->where('name', 'LIKE', '%'. $keyword . '%')
                ->orWhere('gln', 'LIKE', '%'. $keyword . '%');
        }
        
        $rows = $rows->paginate($rpp);

        return LocationResource::collection($rows);
    }
}
