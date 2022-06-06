<?php

namespace App\Observers;

use App\Models\Pallet;
use App\Models\InventoryReport;

class PalletObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;


    /**
     * Handle the Pallet "created" event.
     *
     * @param  \App\Models\Pallet  $inventory
     * @return void
     */
    public function created(Pallet $pallet)
    {
        $this->trigger($pallet);
    }

        /**
     * Handle the Pallet "updated" event.
     *
     * @param  \App\Models\Pallet  $pallet
     * @return void
     */
    public function updated(Pallet $pallet)
    {
        $this->trigger($pallet);
    }


    /**
     * Handle the Pallet "deleted" event.
     *
     * @param  \App\Models\Pallet  $pallet
     * @return void
     */
    public function deleted(Pallet $pallet)
    {
        $this->trigger($pallet);
    }


    public function trigger($pallet)
    {
        $total = Pallet::where('inventory_report_id', $pallet->inventory_report_id)->sum('qty');
        $count = Pallet::where('inventory_report_id', $pallet->inventory_report_id)->count('number');
        $report = InventoryReport::find($pallet->inventory_report_id);
        if($report) {
            $report->update(['total' => $total, 'pallet_qty' => $count]);
        }
    }

}
