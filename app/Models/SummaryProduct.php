<?php

namespace App\Models;

use App\Models\Icons;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SummaryProduct extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function icons()
    {
        return $this->belongsTo(Icons::class, 'icon', 'id');
    }
}
