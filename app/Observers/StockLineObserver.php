<?php

namespace App\Observers;

use App\Models\AddStockLine;

class StockLineObserver
{
    /**
     * Handle the AddStockLine "created" event.
     *
     * @param  \App\Models\AddStockLine  $addStockLine
     * @return void
     */
    public function created(AddStockLine $addStockLine)
    {
         $addStockLine->product->variations()->update(['default_sell_price'=>$addStockLine->sell_price]);
    }

    /**
     * Handle the AddStockLine "updated" event.
     *
     * @param  \App\Models\AddStockLine  $addStockLine
     * @return void
     */
    public function updated(AddStockLine $addStockLine)
    {
        //
    }

    /**
     * Handle the AddStockLine "deleted" event.
     *
     * @param  \App\Models\AddStockLine  $addStockLine
     * @return void
     */
    public function deleted(AddStockLine $addStockLine)
    {
        //
    }

    /**
     * Handle the AddStockLine "restored" event.
     *
     * @param  \App\Models\AddStockLine  $addStockLine
     * @return void
     */
    public function restored(AddStockLine $addStockLine)
    {
        //
    }

    /**
     * Handle the AddStockLine "force deleted" event.
     *
     * @param  \App\Models\AddStockLine  $addStockLine
     * @return void
     */
    public function forceDeleted(AddStockLine $addStockLine)
    {
        //
    }
}
