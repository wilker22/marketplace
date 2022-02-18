<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model
{
    use HasFactory;

    protected $fillable = ['reference', 'pagseguro_code', 'pagseguro_status', 'store_id', 'items'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
