<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    const UPDATED_AT = null;

    protected $primaryKey = 'id';

    //
    protected $fillable = [
        'name', 'phone',
    ];

    public static function getClientIdByPhone($phone)
    {
        $client = Clients::where('phone', $phone)->where('deleted', 0)->first();
        return (!empty($client->id)) ? $client->id : false;
    }

    public function orders()
    {
        return $this->hasMany('App\Orders', 'client_id');
    }
}
