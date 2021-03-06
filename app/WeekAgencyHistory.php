<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Backend\Report\RepoReportController as Report;

class WeekAgencyHistory extends Model
{
    protected $fillable = [
        'week_year', 'level_1', 'level_2', 'level_3', 'level_4', 'level_5', 'total', 'user_id', 'created_at', 'updated_at'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('week_agency_history');
    }

    
}
