<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Package;
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
            'packageName' => 'required|string',
            'sku' => 'required|string',
        ]);

        $package = Package::whereProductId($validatedData['sku'])->first();

        $token = Token::create([
            'order_id' => $validatedData['mOriginalJson']['orderId'],
            'package_name' => $validatedData['mOriginalJson']['packageName'],
            'product_id' => $validatedData['sku'],
            'purchase_time' => $validatedData['mOriginalJson']['purchaseTime'],
            'purchase_state' => $validatedData['mOriginalJson']['purchaseState'],
            'purchase_token' => $validatedData['mOriginalJson']['purchaseToken'],
            'acknowledged' => $validatedData['mOriginalJson']['acknowledged'],
            'signature' => $validatedData['mSignature'],
            'original_json' => json_encode($validatedData['mOriginalJson']),
            'sku' => $validatedData['sku'],
            'client_id' => Client::first()->id,
            'package_id' => $package->id,
        ]);

        return response()->json([
            'code' => 200,
            'data' => $token,
            'message' => 'Token added successfully',
        ]);
    }
}
