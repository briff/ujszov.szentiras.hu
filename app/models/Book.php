<?php
/**

 */

class Book extends Eloquent {

    protected $table = 'konyvnevek';
    protected $primaryKey = 'nev';

    /**
     * @param int $id
     * @return Book
     */
    public static function findById($id) {
        return self::where('konyv_id', $id)->where('tipus', 'default')->first();
    }

} 