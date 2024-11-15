<?php

namespace App\Http\Controllers;

use App\Models\Sku;
use Filament\Facades\Filament;
use Illuminate\Http\Request;

class SkuController extends Controller
{
    public function getList(Request $request)
    {
        return response()->json(
            Sku::whereTeamId(Filament::getTenant()->id)
                ->when($request->input('package_name'), fn($query, $packageName) => $query->wherePackageName($packageName))
                ->paginate($request->input('limit', 20))
        );
    }

    public function getListSkusHasTokens(Request $request)
    {
        return response()->json(
            Sku::whereTeamId(Filament::getTenant()->id)
                ->when($request->input('package_name'), fn($query, $packageName) => $query->wherePackageName($packageName))
                ->whereHas('dumpableTokens')
                ->withCount('dumpableTokens')
                ->paginate($request->input('limit', 20))
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
