<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RandCronjobBinaryInterest extends Model
{
    
    protected $fillable = [
        'created_at', 'updated_at', 'hour_run', 'next_week'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('rand_cronjob_binary_interest');
    }
}
