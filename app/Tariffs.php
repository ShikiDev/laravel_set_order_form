<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tariffs extends Model
{
    //
    const CREATED_AT = null;
    const UPDATED_AT = null;


    /**
     * Получаем дни доставки заказа.
     *
     * @return array
     */
    public function getDeliveryDay()
    {
        $delivery_days = explode(',', $this->delivery_days);
        $delivery_days_arr = [];

        foreach ($delivery_days as $day) $delivery_days_arr[$day] = \DateTime::createFromFormat('D', $day)->format('d.m.Y');
        usort($delivery_days_arr, function ($a, $b) {
            return (strtotime($a) > strtotime($b)) ? 1 : -1;
        });
        $this->delivery_days = $delivery_days_arr;
    }
}
