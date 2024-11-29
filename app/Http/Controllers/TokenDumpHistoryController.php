<?php

namespace App\Http\Controllers;

use App\Models\Sku;
use Filament\Facades\Filament;
use Illuminate\Http\Request;

class TokenDumpHistoryController extends Controller
{
    public function dump(Request $request)
    {
        // Validate the request: skuId must be an integer, number is required and positive
        $request->validate([
            'number' => 'required|integer|min:1',
            'product_id' => 'required',
            'package_name' => 'required',
        ]);

        // Get sku by product_id and package_name

        $sku = Sku::whereProductId($request->product_id)->wherePackageName($request->package_name)->firstOrFail();

        // Get the number of tokens to dump
        $number = $request->input('number');

        // Get quota of tokens to dump (Team->coin)
        if ($number > Filament::getTenant()->coin) {
            return response()->json([
                'message' => 'Not enough coin to dump',
                'remaining_quota' => Filament::getTenant()->coin,
            ], 400);
        }

        // Get available tokens to dump: if user is TeamAdmin get all tokens of that team, otherwise get only user's tokens
        $availableTokensCount = $sku->dumpableTokens()->count();
        if ($availableTokensCount < $number) {
            return response()->json([
                'message' => 'Not enough tokens to dump',
                'remaining_tokens' => $availableTokensCount,
            ], 400);
        }

        // Dump tokens
        $tokens = $sku->dumpTokens($number);

        return response()->json([
            'message' => 'Tokens dumped successfully',
            'tokens' => $tokens,
        ]);
    }
}
