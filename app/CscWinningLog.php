<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CscWinningLog extends Model
{
	use Notifiable, HasRoles;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'email', 'csc_id'
	];

	public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->setTable('cscjackpot_winning_log');
    }

}

