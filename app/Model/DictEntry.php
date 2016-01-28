<?php

/**
 * @property mixed bk
 * @property mixed strong
 * @property mixed elem
 * @property mixed mj
 * @property mixed valt
 * @property mixed szf
 * @property mixed szal
 * @property mixed gk
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DictEntry extends Model {

    protected $table = 'szot';
    protected $primaryKey = 'gk';
    public $timestamps = false;


} 