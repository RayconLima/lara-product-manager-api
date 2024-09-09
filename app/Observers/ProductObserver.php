<?php

namespace App\Observers;
use App\Models\Product;
use App\Jobs\SaveAudit;

class ProductObserver
{
    public function created(Product $product)
    {
        SaveAudit::dispatch([
            'event'             => __METHOD__,
            'user_id'           => auth()->id(),
            'when'              => now(),
            'auditable_id'      => $product->id,
            'auditable_type'    => Product::class,
        ]);
    }

    public function updated(Product $product)
    {
        $oldData = $product->getOriginal();
        $newData = $product->getDirty();

        SaveAudit::dispatch([
            'event'             => __METHOD__,
            'user_id'           => auth()->id(),
            'when'              => now(),
            'auditable_id'      => $product->id,
            'auditable_type'    => Product::class,
            'details' => [
                'old' => $oldData,
                'new' => $newData
            ]
        ]);
    }

    public function deleted(Product $product)
    {
        SaveAudit::dispatch([
            'event'             => __METHOD__,
            'user_id'           => auth()->id(),
            'when'              => now(),
            'auditable_id'      => $product->id,
            'auditable_type'    => Product::class
        ]);
    }
}
