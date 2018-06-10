<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Backend\Report\RepoReportController as Report;

class Awards extends Model
{
    protected $fillable = [
        'week_year', 'value', 'user_id', 'created_at', 'updated_at'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('awards');
    }

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
