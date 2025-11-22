<?php
// app/Http/Controllers/Api/SaleController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        // Проверка токена
        $validToken = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';
        $requestToken = $request->get('key');

        if (!$requestToken || $requestToken !== $validToken) {
            return response()->json(['error' => 'Token invalid or empty'], 403);
        }

        // Валидация
        $request->validate([
            'dateFrom' => 'required|date_format:Y-m-d',
            'dateTo' => 'required|date_format:Y-m-d',
            'page' => 'sometimes|integer|min:1',
            'limit' => 'sometimes|integer|min:1|max:500'
        ]);

        $query = Sale::whereBetween('date', [$request->dateFrom, $request->dateTo])
            ->orderBy('date', 'desc');

        $sales = $query->paginate($request->get('limit', 500));

        return response()->json([
            'data' => $sales->items(),
            'links' => [
                'first' => $sales->url(1),
                'last' => $sales->url($sales->lastPage()),
                'prev' => $sales->previousPageUrl(),
                'next' => $sales->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $sales->currentPage(),
                'from' => $sales->firstItem(),
                'last_page' => $sales->lastPage(),
                'path' => $request->url(),
                'per_page' => $sales->perPage(),
                'to' => $sales->lastItem(),
                'total' => $sales->total(),
            ]
        ]);
    }
}
