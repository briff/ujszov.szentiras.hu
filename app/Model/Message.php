<?php
/**

 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {

    protected $table="vendegk";
    protected $primaryKey="ssz";

    public function repliedTo() {
        return $this->belongsTo(Model::class);
    }

} 