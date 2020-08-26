<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Relations\Pivot;

class CinemaShow extends Pivot
{


    public function show()
    {
        return $this->belongsTo(Show::class);
    }

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }
}
