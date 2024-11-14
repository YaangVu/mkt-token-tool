<?php

namespace App\Http\Controllers;

use App\Models\Sku;

class SkuController extends Controller
{
    public function getList()
    {
        return response()->json(Sku::paginate(10));
    }
}
