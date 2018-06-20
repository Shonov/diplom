<?php

namespace ProfPlatforma\Orders\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ProfPlatforma\Orders\Models\Image;
use ProfPlatforma\Orders\Models\Order;
use ProfPlatforma\Orders\Requests\CreateOrderRequest;
use ProfPlatforma\Orders\Requests\GetAllOrdersRequest;
use ProfPlatforma\Orders\Requests\UpdateOrderRequest;
use ProfPlatforma\Orders\Services\OrdersService;

class OrderController extends Controller
{
    private $ordersService;

    public function __construct(OrdersService $ordersService)
    {
        $this->ordersService = $ordersService;
    }

    /**
     * Создать заказ
     *
     * @response {
     *  "id": "1"
     *}
     */
    public function create(CreateOrderRequest $request)
    {
        return [
            'id' => $this->ordersService->create($request->validated())
        ];
    }

    /**
     * Отображение Заказа (Show Order)
     *
     * @response {
     *  "Заказ": "{"id": 1,"title": "","description": "" ....}"
     *}
     */
    public function show(Order $order)
    {
        return [
            'order' => $this->ordersService->show($order),
            'user' => $order->author
        ];
    }

    /**
     * Обновление Заказа (Update Order)
     *
     * @response {
     *  "status": "true"
     *}
     */
    public function update(Request $request, Order $order)
    {
        return [
            'status' => $this->ordersService->update($order, $request->all())
        ];
    }

    /**
     * Удаление заказа (Delete Order)
     *
     * @response {
     *  "status":"true"
     *}
     */

    public function delete(Order $order)
    {
        return [
            'status' => $this->ordersService->delete($order)
        ];
    }

    /**
     * Список заказов
     */
    public function getAll(GetAllOrdersRequest $request)
    {
        $limit = $request->get('limit', null);
        $offset = $request->get('offset', 0);

        return $this->ordersService->getAll($limit, $offset);
    }

    /**
     * Обработка фотографий заказа
     * @param Request $request
     */
    public function upload(Request $request)
    {
//        $order = Order::find($request->id);
//        dd($_FILES);
        foreach ($request->file() as $files) {
            foreach ($files as $file) {
                $file->move(storage_path('images\\'), $file->getClientOriginalName());
                $img = Image::create(['photo' => $file->getClientOriginalName()]);
                $img->save();
            }
        }
    }
}
