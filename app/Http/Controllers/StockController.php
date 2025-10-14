<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $stock = Stock::create(
            $request->only([
                'product_id',
                'variation',
                'quantity'
            ])
        );

        return response()->json($stock, 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $stock = Stock::findOrFail($id);
        $stock->update($request->only(['variation', 'quantity']));

        return response()->json($stock);
    }

    public function destroy($id): JsonResponse
    {
        Stock::destroy($id);

        return response()->json(null, 204);
    }
}
