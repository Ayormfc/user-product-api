<?php

namespace App\Models;

// 1. IMPORT THIS
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'quantity', 'unit_price', 'amount_sold', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}