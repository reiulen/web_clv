<?php

namespace App\Models;

use App\Models\DetailProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\SummaryProduct;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function detailProduct()
    {
        return $this->hasMany(DetailProduct::class);
    }

    public function summaryProduct()
    {
        return $this->hasMany(SummaryProduct::class);
    }

    public function views()
    {
        return $this->hasMany(ViewProduct::class);
    }

    public function scopeFilter($query, $request)
    {
        $query->when($request->name ?? false, function ($query) use ($request) {
            return $query->where('name', 'like', "%$request->name%");
        })->when($request->date ?? false, function ($query) use ($request) {
            return $query->where('created_at', 'like', "%$request->date%");
        })->when($request->status ?? false, function ($query) use ($request) {
            return $query->where('status', $request->status);
        });
    }
}
