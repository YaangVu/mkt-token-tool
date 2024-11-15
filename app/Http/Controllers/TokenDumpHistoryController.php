<?php

namespace App\Http\Controllers;

use App\Models\Sku;
use App\Models\Token;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class TokenDumpHistoryController extends Controller
{
    public function dump(Request $request, int|string $productId)
    {
        // Validate the request: skuId must be an integer, number is required and positive
        $request->validate([
            'number' => 'required|integer|min:1',
        ]);

        $sku = Sku::whereProductId($productId)->firstOrFail();

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
        $dump = $sku->dumpTokens($number);
        $tokens = $dump->tokens->map(fn(Token $token) => ['id' => $token->id, 'purchase_token' => Crypt::decrypt($token->purchase_token)]);

        return response()->json([
            'message' => 'Tokens dumped successfully',
            'tokens' => $tokens,
        ]);
    }
}
