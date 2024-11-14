<?php

namespace App\Http\Controllers;

use App\Http\Middleware\TeamMiddleware;
use App\Models\Sku;
use Filament\Facades\Filament;
use Illuminate\Http\Request;

class SkuController extends Controller
{
    public function getList(Request $request)
    {
        return response()->json(
            Sku::whereTeamId(Filament::getTenant()->id)
                ->paginate($request->input('limit', 10))
        );
    }

    public function getListSkusHasTokens(Request $request)
    {
        return response()->json(
            Sku::whereTeamId(Filament::getTenant()->id)
                ->whereHas('dumpableTokens')
                ->withCount('dumpableTokens')
                ->paginate($request->input('limit', 10))
        );
    }

    public function getSkuByProductId(string $productId)
    {
        return response()->json(
            Sku::whereTeamId(Filament::getTenant()->id)
                ->whereProductId($productId)
                ->withCount('tokens')->first()
        );
    }
}
