<?php

namespace App\Observers;

use Carbon\Carbon;
use LogicException;
use App\Models\Shift;
use App\Models\Product;
use App\Models\Schedule;
use App\Models\Inventory;
use App\Events\InventoryIn;
use App\Models\InventoryReport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

class InventoryObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the Inventory "creating" event.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return void
     */
    public function creating(Inventory $inventory)
    {
        if(! Product::whereGtin($inventory->gtin)->first()) {
            throw new LogicException('Invalid SKU barcode');
        }

        $schedule = $this->schedule();
        $inventory->schedule_id = $schedule->id;
    }

    /**
     * Handle the Inventory "created" event.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return void
     */
    public function created(Inventory $inventory)
    {
        $this->counter($inventory);
        InventoryIn::dispatch($inventory);
    }

    /**
     * Handle the Inventory "updated" event.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return void
     */
    public function updated(Inventory $inventory)
    {
        //
    }

    /**
     * Handle the Inventory "deleted" event.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return void
     */
    public function deleted(Inventory $inventory)
    {
        $this->counter($inventory, 'decrement');
    }

    /**
     * Handle the Inventory "restored" event.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return void
     */
    public function restored(Inventory $inventory)
    {
        //
    }

    /**
     * Handle the Inventory "force deleted" event.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return void
     */
    public function forceDeleted(Inventory $inventory)
    {
        //
    }

    public function schedule()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $active = Schedule::with('shift')->where('from', '<=', $now)->where('to', '>=', $now)->first();
        if(! $active) {
            $exitCode = Artisan::call('attendance:schedule:generator', [
                '--from' => $now
            ]);
            $active = Schedule::with('shift')->where('from', '<=', $now)->where('to', '>=', $now)->first();
        }
       
        return $active;
    }

    public function counter($inventory, $opt = 'increment')
    {
        $product = Product::whereGtin($inventory->gtin)->first();
        $schedule = $this->schedule();
        
        $report = InventoryReport::where('product_id', $product->id)
            ->where('location_id', $inventory->location_id)
            ->where('schedule_id', $schedule->id)
            ->latest()
            ->first();
            
        if(! $report && $opt == 'increment') {
            $report = new InventoryReport;
            $report->fill([
                'product_id' => $product->id,
                'location_id' => $inventory->location_id,
                'schedule_id' => $schedule->id,
                'qty' => 1
            ]);
            $report->save();
        }else{
            if($opt == 'increment') {
                $report->increment('qty');
            }elseif($opt == 'decrement') {
                $report->decrement('qty');
            }
        }
    }
}
