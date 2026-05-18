<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model {
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function toLocation()
    {
        return $this->belongsTo(Location::class, 'to_location_id');
    }

    public function fromLocation()
    {
        return $this->belongsTo(Location::class, 'from_location_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
