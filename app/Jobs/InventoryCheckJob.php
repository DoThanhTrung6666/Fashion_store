<?php

namespace App\Jobs;

use App\Mail\mailQuantity;
use App\Models\ProductVariant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InventoryCheckJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    private $productVariantIds;
    public function __construct(array $productVariantIds)
    {
        $this->productVariantIds = $productVariantIds;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //

        $productVariants = ProductVariant::with('product')
                                            ->whereIn('id',$this->productVariantIds)
                                           ->where('stock_quantity','<=',5)
                                           ->get();
        Log::info($this->productVariantIds);
        Log::info($productVariants);
        Mail::to('trungdtph40224@fpt.edu.vn')->send(new mailQuantity($productVariants));


    }
}
