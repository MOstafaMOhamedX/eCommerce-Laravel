<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, SearchableTrait, Searchable;
    protected $table='products';
    protected $fillable = ['quantity'];
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'products.name' => 10,
            'products.details' => 5,
            'products.description' => 5,
        ],
    ];
    public function presentPrice()
    {
        return  '$' . number_format(str_replace(",","",$price)  ,2);
    }
    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }
    public function orders()
    {
        return $this->belongsToMany('App\Models\Order');
    }
    public function roles()
    {
        return $this->belongsToMany('App\Models\Order', 'order_product', 'order_id', 'product_id');
    }
    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        $extraFields = [
            'categories' => $this->categories->pluck('name')->toArray(),
        ];

        return array_merge($array, $extraFields);
    }
}