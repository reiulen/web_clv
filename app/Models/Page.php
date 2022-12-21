<?php

namespace App\Models;

use App\Models\TypePage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function typePage()
    {
        return $this->belongsTo(TypePage::class, 'type_page_id');
    }

    public function scopeFilter($query, $request)
    {
        $query->when($request->title ?? false, function ($query) use ($request) {
            return $query->where('title', 'like', "%$request->title%");
        })->when($request->date ?? false, function ($query) use ($request) {
            return $query->where('created_at', 'like', "%$request->date%");
        })->when($request->status ?? false, function ($query) use ($request) {
            return $query->where('status', $request->status);
        })->when($request->type_page_id ?? false, function ($query) use ($request) {
            return $query->where('type_page_id', $request->type_page_id);
        });
    }
}
