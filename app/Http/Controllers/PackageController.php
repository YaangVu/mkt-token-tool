<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PackageController extends Controller
{
    public function getList()
    {
        $packages = Package::all()->map(function ($package) {
            return [
                '_id' => $package->id,
                'price' => $package->price,
                'price_currency_code' => $package->currency,
                'productId' => $package->game->name,
                'title' => $package->title,
                'type' => $package->type,
                'createdTime' => $package->created_at->toIso8601String(),
                'idInt' => $package->id,
                'game_id' => $package->game->id,
                'id' => $package->id,
                'packageName' => $package->code
            ];
        });

        return response()->json([
            'code' => 200,
            'data' => $packages,
            'message' => '',
            'serviceTime' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
