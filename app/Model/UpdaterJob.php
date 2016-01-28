<?php
/**

 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UpdaterJob extends Model {


    public function getMessages() {
        return $this->hasMany('\App\Model\UpdaterJobMessage');
    }

} 