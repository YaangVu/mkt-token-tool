<?php

namespace App\Http\Controllers;

use App\Http\Middleware\TeamMiddleware;
use App\Models\Sku;
use App\Models\Token;
use App\Models\TokenDumpHistory;
use Filament\Facades\Filament;
use Illuminate\Http\Request;

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

        // Get available tokens to dump: if user is TeamAdmin get all tokens of that team, otherwise get only user's tokens
        $tokensQueryBuilder = auth()->user()->can('viewAny', TokenDumpHistory::class)
            ? Token::whereSkuId($sku->id)->whereTeamId(Filament::getTenant()->id)->whereDumpHistoryId(null)
            : Token::whereSkuId($sku->id)->whereTeamId(Filament::getTenant()->id)->whereDumpHistoryId(null)->whereOwnerId(auth()->id());

        $numberOfAvailableTokens = $tokensQueryBuilder->count();
        if ($numberOfAvailableTokens < $number) {
            return response()->json([
                'message' => 'Not enough tokens to dump',
                'remaining_tokens' => $numberOfAvailableTokens,
            ], 400);
        }

        // Dump tokens
        $dump = $sku->dumpTokens($number);

        return response()->json([
            'message' => 'Tokens dumped successfully',
            'tokens' => $dump->tokens()->pluck('purchase_token'),
        ]);
    }
}
