<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderList extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $dates = ['deleted_at'];

    protected $primaryKey = 'id';

    protected $table = 'order_lists';

    protected $fillable = [
        "id",
        "user_id",
        "amount",
        "price",
        "total",
        "created_at",
        "updated_at"
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('order_lists');
    }

    public function getDataTable(){

    }
}
