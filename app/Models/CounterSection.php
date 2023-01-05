<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounterSection extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, $request)
    {
        $query->when($request->name ?? false, function ($query) use ($request) {
            return $query->where('name', 'like', "%$request->name%");
        })->when($request->date ?? false, function ($query) use ($request) {
            return $query->where('created_at', 'like', "%$request->date%");
        })->when($request->content ?? false, function ($query) use ($request) {
            return $query->where('content', 'like', "%$request->content%");
        });
    }
}
