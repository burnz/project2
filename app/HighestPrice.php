<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class HighestPrice extends Model
{
    protected $fillable = [
        'created_at', 'updated_at', 'highest_price', 'highest_price_btc'
    ];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->setTable('high_price_yesterday');
    }

    public static function getCarHighestPrice() {
        $data = DB::table('high_price_yesterday')
                ->select('highest_price', 'highest_price_btc')
                ->first();
        $price = round($data->highest_price_btc * $data->highest_price, 5);
        if($price == 0) $price = 1;

        return $price;
    }    
}
