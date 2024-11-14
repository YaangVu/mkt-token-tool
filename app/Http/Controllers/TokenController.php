<?php

namespace App\Http\Controllers;

use App\Models\Sku;
use App\Models\Token;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function addToken(Request $request)
    {
        $validatedData = $request->validate([
            'mOriginalJson' => 'required',
//            'mOriginalJson.packageName' => 'required|string',
//            'mOriginalJson.productId' => 'required|string',
//            'mOriginalJson.purchaseTime' => 'required|integer',
//            'mOriginalJson.purchaseState' => 'required|integer',
            'mOriginalJson.purchaseToken' => 'required|string',
//            'mOriginalJson.acknowledged' => 'required|boolean',
            'mSignature' => 'required|string',
            'orderId' => 'required|string',
            'skuName' => 'required|string',
            'sku' => 'required|string',
        ]);

        $sku = Sku::whereProductId($validatedData['sku'])->first();

        if (!$sku) {
            return response()->json([
                'code' => 404,
                'data' => null,
                'message' => 'SKU not found',
            ], 400);
        }

        $token = Token::create([
            'order_id' => $validatedData['mOriginalJson']['orderId'],
            'sku_name' => $validatedData['mOriginalJson']['skuName'],
            'product_id' => $validatedData['sku'],
            'purchase_time' => $validatedData['mOriginalJson']['purchaseTime'],
            'purchase_state' => $validatedData['mOriginalJson']['purchaseState'],
            'purchase_token' => $validatedData['mOriginalJson']['purchaseToken'],
            'acknowledged' => $validatedData['mOriginalJson']['acknowledged'],
            'signature' => $validatedData['mSignature'],
            'original_json' => json_encode($validatedData['mOriginalJson']),
            'sku' => $validatedData['sku'],
            'client_id' => 1, // TODO: Replace with actual client ID
            'sku_id' => $sku->id,
            'owner_id' => auth()->id(),
            'created_by' => auth()->id(),
        ]);

        return response()->json([
            'code' => 200,
            'data' => $token,
            'message' => 'Token added successfully',
        ]);
    }
}
