<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function views()
    {
        return $this->hasMany(ViewArtikel::class);
    }

    public function scopeFilter($query, $request)
    {
        $query->when($request->title ?? false, function ($query) use ($request) {
            return $query->where('title', 'like', "%$request->title%");
        })->when($request->date ?? false, function ($query) use ($request) {
            return $query->where('created_at', 'like', "%$request->date%");
        })->when($request->status ?? false, function ($query) use ($request) {
            return $query->where('status', $request->status);
        });
    }
}
