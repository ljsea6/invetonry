<?php

namespace App;

use App\Inventory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $guarded = ['id'];

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'product_id');
    }

}
