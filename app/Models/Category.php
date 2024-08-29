<?php

namespace App\Models;

use App\Exceptions\NotDeleteException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    protected static function booted()
    {
        static::deleting(function ($category) {
            if($category->products->count() > 0) {
                // throw new \Exception('Category cannot be deleted because it has products');
                throw new NotDeleteException();
            }
        });
            // $lastProduct = static::query()->orderBy('id', 'desc')->first();
            // if ($lastProduct) {
            //     $product->sku = 'PROD-' . str_pad($lastProduct->getKey() + 1, 4, '0', STR_PAD_LEFT);
            // } else {
            //     $product->sku = 'PROD-0001';
            // }
        // });
    }
}
