<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestBrosur extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function scopeFilter($query, $request)
    {
        $query->when($request->name ?? false, function ($query) use ($request) {
            return $query->where('name', 'like', "%$request->name%");
        })->when($request->email ?? false, function ($query) use ($request) {
            return $query->where('email', 'like', "%$request->email%");
        })->when($request->phone ?? false, function ($query) use ($request) {
            return $query->where('phone', 'like', "%$request->phone%");
        })->when($request->created_at ?? false, function ($query) use ($request) {
            return $query->where('created_at', 'like', "%$request->created_at%");
        })->when($request->product ?? false, function ($query) use ($request) {
            return $query->where('product_id', $request->product);
        });
    }
}
