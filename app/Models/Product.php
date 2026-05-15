<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }
    
    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }
}
