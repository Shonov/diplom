<?php
/**
 * Created by PhpStorm.
 * User: Vitaly
 * Date: 12.03.2018
 * Time: 18:58
 */

namespace ProfPlatforma\Orders\Services;

use ProfPlatforma\Orders\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrdersService
{
    public function create($values)
    {
        $order = new Order($values);
        $order->save();
        return $order->id;
    }

    public function show(Order $order)
    {
        $order->budget_scale_id = $order->budget->interval;
        return $order;
    }

    public function update(Order $order, $values)
    {
        if ($order->author->id == Auth::user()->id) {
            return $order->update($values);
        }
    }

    public function delete(Order $order)
    {
        if ($order->author->id == Auth::user()->id) {
            return $order->delete();
        }
    }

        public function getAll($limit, $offset)
    {
        $orders = Order::limit($limit)
            ->offset($offset)
            ->orderBy('id')
            ->get();
        foreach ($orders as &$order) {
            if ($order->budget_scale_id) {
                $order->budget_scale_id = $order->budget->interval;
                unset($order);
            }
        }
        return [
            'data' => $orders,
            'count' => Order::all()->count(),
        ];
    }
}