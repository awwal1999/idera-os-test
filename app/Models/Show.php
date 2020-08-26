<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * @property string name
 * @property string description
 * @property int id
 */
class Show extends Model
{

    public function cinema()
    {
        return $this->belongsToMany(Cinema::class);
    }
}
