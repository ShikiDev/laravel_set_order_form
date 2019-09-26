<?php

namespace App\Http\Controllers;

use App\Clients;
use App\Orders;
use App\Tariffs;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    //

    public function index()
    {
        $tariffs = Tariffs::all();
        foreach ($tariffs as &$tariff) $tariff->getDeliveryDay();
        return view('orders', [
            'tariffs' => $tariffs,
        ]);
    }

    public function store(Request $request)
    {
        $result = [
            'status' => 'success',
            'message' => 'Ok'
        ];

        try {
            $order = new Orders();
            $phone = $request->input('phone', '');
            $tariff_id = $request->input('tariff_id', 0);
            $first_date = $request->input('first_date', '');

            if (empty($phone)) throw new \Exception('Телефон не указан или произошла внутренняя ошибка при передаче данных');
            if (empty($tariff_id)) throw new \Exception('Тариф не указан или произошла внутренняя ошибка при передаче данных');
            if (empty($first_date)) throw new \Exception('Не выбран первый день доставки или произошла внутрення ошибка при передаче данных');

            $client_id = Clients::getClientIdByPhone($phone);
            if (empty($client_id)) {
                $client = new Clients();
                $client->name = $request->input('name', '');
                $client->phone = $phone;
                $client->save();
            } else {
                $client = Clients::where('deleted', 0)->where('id', $client_id)->first();
                $client->name = $request->input('name', '');
            }

            $order->client_id = $client->id;
            $order->tariff_id = $tariff_id;
            $order->address = $request->input('address', '');
            $order->first_date = \DateTime::createFromFormat('d.m.Y', $first_date);
            $order->order_date = new \DateTime('now');
            $order->save();
        } catch (\Exception $exception) {
            $result['status'] = 'error';
            $result['message'] = $exception->getMessage() . '. Попробуйте позже или свяжитесь с службой тех. поддержки.';
        }

        return $result;
    }

    public function find(Request $request)
    {
        $result = [
            'status' => 'success',
            'message' => 'Ok',
            'data' => []
        ];

        $string = $request->input('string', '');
        $client = Clients::where('deleted', 0)->where('phone', $string)->first();

        if (!empty($client)) {
            $result['data']['client'] = $client;
            $orders = $client->orders;
            if (!empty($orders)) {
                foreach ($orders as $order) {
                    $order_temp = [];
                    $order_tariff = $order->tariff;
                    $order_temp['id'] = $order->id;
                    $order_temp['tariff_name'] = $order_tariff->name;
                    $order_temp['tariff_price'] = $order_tariff->price;
                    $order_temp['address'] = $order->address;
                    $order_temp['first_date'] = $order->first_date;
                    $order_temp['order_date'] = $order->order_date;
                    $result['data']['client_orders'][] = $order_temp;
                }
            } else {
                $result['data']['client_orders'] = [];
            }
        } else {
            $result['data']['client'] = [];
            $result['data']['client_orders'] = [];
        }

        return $result;
    }
}
