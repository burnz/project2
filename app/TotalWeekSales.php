<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TotalWeekSales extends Model
{

    protected $primaryKey = 'id';

    protected $fillable = [
		'userId', 'total_interest', 'weekYear'
	];

	public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('total_week_sales');
    }
    public function userData() {
        return $this->hasOne(UserData::class, 'userId', 'userId');
    }

    public function userCoin() {
        return $this->hasOne(UserCoin::class, 'userId', 'userId');
    }
}
