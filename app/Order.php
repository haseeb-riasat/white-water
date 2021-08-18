<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table="orders";
    protected $guarded=[];
    // for products relation through PIVOT TABLE
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('price','quantity');
    }
    //for customer relation
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
