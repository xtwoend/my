<?php

namespace App\Observers;

use App\Models\ProductReturn;
use App\Models\InventoryReport;

class ProductReturnObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;


    /**
     * Handle the ProductReturn "created" event.
     *
     * @param  \App\Models\ProductReturn  $inventory
     * @return void
     */
    public function created(ProductReturn $ProductReturn)
    {
        $this->trigger($ProductReturn);
    }

        /**
     * Handle the ProductReturn "updated" event.
     *
     * @param  \App\Models\ProductReturn  $ProductReturn
     * @return void
     */
    public function updated(ProductReturn $ProductReturn)
    {
        $this->trigger($ProductReturn);
    }

    /**
     * Handle the ProductReturn "deleted" event.
     *
     * @param  \App\Models\ProductReturn  $ProductReturn
     * @return void
     */
    public function deleted(ProductReturn $ProductReturn)
    {
        $this->trigger($ProductReturn);
    }


    public function trigger($ProductReturn)
    {
        $total = ProductReturn::where('inventory_report_id', $ProductReturn->inventory_report_id)->sum('qty');
        $report = InventoryReport::find($ProductReturn->inventory_report_id);
        if($report) {
            $report->update(['return_qty'=> $total]);
        }
    }
}
