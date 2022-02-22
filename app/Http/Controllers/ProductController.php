<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Exports\ProductExport;
use PhpMqtt\Client\Facades\MQTT;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        return view('product.index');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'gtin' => 'required',
            'name' => 'required'
        ]);

        $product = Product::whereGtin($request->gtin)->first();
        if(! $product){
            $product = new Product;
        }

        $product->fill($request->all());
        $product->save();

        if($request->ajax()){
            return response()->json(['success' => true]);
        }

        return redirect()->route('product');
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'gtin' => 'required',
            'name' => 'required'
        ]);

        $product = Product::find($id);
        $product->fill($request->all());
        $product->save();

        if($request->ajax()){
            return response()->json(['success' => true]);
        }

        return redirect()->route('product');
    }

    public function remove($id)
    {
        return Product::find($id)->delete();
    }

    public function data(Request $request)
    {
        $rpp = $request->input('per_page', 20);
        $rows = new Product;
        if($request->has('sort') && $request->sort != '') {
            list($sort, $dir) = explode('|', $request->sort);
            $rows = $rows->orderBy($sort, $dir);
        }
        if($request->has('q') && $request->q != ''){
            $keyword = $request->input('q');
            $rows = $rows->where('name', 'LIKE', '%'. $keyword . '%')
                ->orWhere('gtin', 'LIKE', '%'. $keyword . '%');
        }
        $rows = $rows->paginate($rpp);
        return ProductResource::collection($rows);
    }

    public function download()
    {
        return Excel::download(new ProductExport, 'product.xlsx');
    }

    public function sendToMQTT()
    {
        $products = Product::select('name', 'gtin', 'line')->get();
        $rows = $products->map(function($row) {
            return [
                'barcode' => $row->gtin,
                'name' => $row->name,
                'line' => $row->line
            ];
        });

        $data = $rows->toArray();

        return MQTT::publish('mayora/products', json_encode($data));
    }
}
