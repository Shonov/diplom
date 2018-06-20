<?php

namespace ProfPlatforma\Orders\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ProfPlatforma\Orders\Models\OrderRequest;

class OrderRequestController extends Controller
{
    public function create(Request $request)
    {
        $orderRequest = OrderRequest::create([
            'user_id' => $request['user_id'],
            'order_id' => $request['order_id'],
            'status' => $request['status'],
        ]);
        return $orderRequest->id;
    }

    public function destroy(Request $request, $id)
    {
        return [
            'status' => OrderRequest::destroy($id)
        ];
    }
}
