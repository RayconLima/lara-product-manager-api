<?php

namespace App\Observers;
use App\Models\Category;
use App\Jobs\SaveAudit;

class CategoryObserver
{
    public function created(Category $category)
    {
        SaveAudit::dispatch([
            'event'             => __METHOD__,
            'user_id'           => auth()->id(),
            'when'              => now(),
            'auditable_id'      => $category->id,
            'auditable_type'    => Category::class,
        ]);
    }

    public function updated(Category $category)
    {
        $oldData = $category->getOriginal();
        $newData = $category->getDirty();

        SaveAudit::dispatch([
            'event'             => __METHOD__,
            'user_id'           => auth()->id(),
            'when'              => now(),
            'auditable_id'      => $category->id,
            'auditable_type'    => Category::class,
            'details' => [
                'old' => $oldData,
                'new' => $newData
            ]
        ]);
    }

    public function deleted(Category $category)
    {
        SaveAudit::dispatch([
            'event'             => __METHOD__,
            'user_id'           => auth()->id(),
            'when'              => now(),
            'auditable_id'      => $category->id,
            'auditable_type'    => Category::class
        ]);
    }
}
