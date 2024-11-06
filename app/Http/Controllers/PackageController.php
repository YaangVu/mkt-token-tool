<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PackageController extends Controller
{
    public function getList()
    {
        $packages = Package::all()->map(function (Package $package) {
            return [
                '_id' => $package->id,
                'price' => $package->price,
                'price_currency_code' => $package->price_currency_code,
//                'productId' => $package->product_id,
                'product_id' => $package->product_id,
                'title' => $package->title,
                'type' => $package->type,
//                'createdTime' => $package->created_at->toIso8601String(),
                'created_time' => $package->created_at->toIso8601String(),
//                'idInt' => $package->id,
                'id_int' => $package->id,
                'game_id' => $package->id,
                'id' => $package->id,
//                'packageName' => $package->name
                'package_name' => $package->name
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
