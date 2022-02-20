<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Resources\InventoryResource;

class InventoryInController extends Controller
{
    public function index()
    {
        return view('inventory.line-in');
    }
    
    public function data(Request $request)
    {
        $rows = Inventory::with('product', 'schedule', 'location')->latest()->limit(15)->get();
        return InventoryResource::collection($rows);
    }
}
