<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;

class StocksController extends Controller
{
    public function index(Request $request)
    {
        $validToken = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';
        $requestToken = $request->get('key');

        if (!$requestToken || $requestToken !== $validToken) {
            return response()->json(['error' => 'Token invalid or empty'], 403);
        }

        $request->validate([
            'dateFrom' => 'required|date_format:Y-m-d', // Только dateFrom для складов
            'page' => 'sometimes|integer|min:1',
            'limit' => 'sometimes|integer|min:1|max:500'
        ]);

        // Для складов - только за указанную дату
        $query = Stock::where('date', $request->dateFrom)
            ->orderBy('stock_name', 'asc');

        $stock = $query->paginate($request->get('limit', 500));

        return response()->json([
            'data' => $stock->items(),
            'links' => [
                'first' => $stock->url(1),
                'last' => $stock->url($stock->lastPage()),
                'prev' => $stock->previousPageUrl(),
                'next' => $stock->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $stock->currentPage(),
                'from' => $stock->firstItem(),
                'last_page' => $stock->lastPage(),
                'path' => $request->url(),
                'per_page' => $stock->perPage(),
                'to' => $stock->lastItem(),
                'total' => $stock->total(),
            ]
        ]);
    }
}
