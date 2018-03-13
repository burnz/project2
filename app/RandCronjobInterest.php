<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RandCronjobInterest extends Model
{
    
    protected $fillable = [
        'created_at', 'updated_at', 'hour_run', 'next_date'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('rand_cronjob_interest');
    }
}
