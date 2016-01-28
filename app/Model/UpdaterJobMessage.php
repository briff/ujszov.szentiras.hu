<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UpdaterJobMessage extends Model {

	public function updaterJob() {
        return $this->belongsTo('App\Model\UpdaterJob');
    }

}
