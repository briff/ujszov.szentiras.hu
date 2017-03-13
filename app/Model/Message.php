<?php
/**

 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {

    protected $table="vendegk";
    protected $primaryKey="ssz";

    public function getReplies() {
        return $this->hasMany(Message::class);
    }

    public function repliedMessage() {
        return $this->belongsTo(Message::class, 'replied_to');
    }
} 