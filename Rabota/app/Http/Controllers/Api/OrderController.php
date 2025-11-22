<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $validToken = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';
        $requestToken = $request->get('key');

        if (!$requestToken || $requestToken !== $validToken) {
            return response()->json(['error' => 'Token invalid or empty'], 403);
        }

        $request->validate([
            'dateFrom' => 'required|date_format:Y-m-d',
            'dateTo' => 'required|date_format:Y-m-d',
            'page' => 'sometimes|integer|min:1',
            'limit' => 'sometimes|integer|min:1|max:500'
        ]);

        $query = Order::whereBetween('date', [$request->dateFrom, $request->dateTo])
            ->orderBy('date', 'desc');

        $orders = $query->paginate($request->get('limit', 500));

        return response()->json([
            'data' => $orders->items(),
            'links' => [
                'first' => $orders->url(1),
                'last' => $orders->url($orders->lastPage()),
                'prev' => $orders->previousPageUrl(),
                'next' => $orders->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $orders->currentPage(),
                'from' => $orders->firstItem(),
                'last_page' => $orders->lastPage(),
                'path' => $request->url(),
                'per_page' => $orders->perPage(),
                'to' => $orders->lastItem(),
                'total' => $orders->total(),
            ]
        ]);
    }
}
