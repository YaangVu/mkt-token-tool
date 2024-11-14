<?php

namespace App\Http\Controllers;

use App\Models\Sku;
use App\Models\Token;
use Filament\Facades\Filament;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'original_json' => 'required',
            'purchase_token' => 'required|string',
            'signature' => 'required|string',
            'order_id' => 'required|string',
            'product_id' => 'required|string',
        ]);

        $sku = Sku::whereProductId($validatedData['product_id'])->first();

        if (!$sku) {
            return response()->json([
                'code' => 404,
                'data' => null,
                'message' => 'SKU not found',
            ], 400);
        }

        $token = Token::create([
            'order_id' => $validatedData['order_id'],
            'sku_id' => $sku->id,
            'purchase_token' => $validatedData['purchase_token'],
            'signature' => $validatedData['signature'],
            'original_json' => $validatedData['original_json'],
            'owner_id' => auth()->id(),
            'created_by' => auth()->id(),
            'team_id' => Filament::getTenant()->id,
        ]);

        return response()->json([
            'code' => 200,
            'data' => $token,
            'message' => 'Token added successfully',
        ]);
    }
}
