<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Cronjob extends Model
{
    
    protected $fillable = [
        'created_at', 'updated_at', 'hour_run'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('cronjob');
    }
}
