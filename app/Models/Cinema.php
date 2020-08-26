<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 */
class Cinema extends Model
{
    public function shows()
    {
        return $this->belongsToMany(Show::class);
    }
}
