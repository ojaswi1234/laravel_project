<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Stock extends Model {
    protected $table = 'stock';
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
