<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BonusBinaryInterest extends Model
{
    protected $fillable = [
		'userId', 'leftNew', 'rightNew', 'leftOpen', 'rightOpen', 'bonus', 'weekYear'
	];
	public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('bonus_binary_interest');
    }
    
    public function userData() {
        return $this->hasOne(UserData::class, 'userId', 'userId');
    }

    public function userCoin() {
        return $this->hasOne(UserCoin::class, 'userId', 'userId');
    }
}
