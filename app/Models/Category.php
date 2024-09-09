<?php

namespace App\Models;

use App\Exceptions\NotDeleteException;
use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ObservedBy([CategoryObserver::class])]
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
        parent::boot();
        static::deleting(function ($model) {
            foreach($model->products as $product)
            {
                $product->delete();
            }
        });
    }
}
