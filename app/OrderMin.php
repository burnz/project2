<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/30/2017
 * Time: 11:38 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
class OrderMin extends Model
{

    public $timestamps = true;

    protected $primaryKey = 'id';

    protected $table = 'price_order_list';

    protected $fillable = [
        "id",
        "order_date",
        "price",
        "created_at",
        "updated_at"
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('price_order_list');
    }

}