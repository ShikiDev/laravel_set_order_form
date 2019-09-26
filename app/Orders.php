<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    //
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $primaryKey = 'id';

    public function tariff()
    {
        return $this->hasOne('App\Tariffs', 'id', 'tariff_id');
    }


}
