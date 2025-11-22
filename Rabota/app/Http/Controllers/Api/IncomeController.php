<?php
// app/Http/Controllers/Api/IncomeController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
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

        $query = Income::whereBetween('date', [$request->dateFrom, $request->dateTo])
            ->orderBy('date', 'desc');

        $incomes = $query->paginate($request->get('limit', 500));

        return response()->json([
            'data' => $incomes->items(),
            'links' => [
                'first' => $incomes->url(1),
                'last' => $incomes->url($incomes->lastPage()),
                'prev' => $incomes->previousPageUrl(),
                'next' => $incomes->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $incomes->currentPage(),
                'from' => $incomes->firstItem(),
                'last_page' => $incomes->lastPage(),
                'path' => $request->url(),
                'per_page' => $incomes->perPage(),
                'to' => $incomes->lastItem(),
                'total' => $incomes->total(),
            ]
        ]);
    }
}
