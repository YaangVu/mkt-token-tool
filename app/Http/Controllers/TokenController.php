<?php

namespace App\Http\Controllers;

use App\Constants\DefaultRoles;
use App\Constants\TokenStatuses;
use App\Models\Sku;
use App\Models\Token;
use Filament\Facades\Filament;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'original_json' => 'required',
            'purchase_token' => 'required|string',
            'signature' => 'required|string',
            'order_id' => 'required|string',
            'product_id' => 'required|string',
        ]);

        $sku = Sku::whereProductId($validatedData['product_id'])->first();

        if (!$sku) {
            return response()->json([
                'code' => 404,
                'data' => null,
                'message' => 'SKU not found',
            ], 400);
        }

        $token = Token::create([
            'order_id' => $validatedData['order_id'],
            'sku_id' => $sku->id,
            'purchase_token' => $validatedData['purchase_token'],
            'signature' => $validatedData['signature'],
            'original_json' => $validatedData['original_json'],
            'owner_id' => auth()->id(),
            'created_by' => auth()->id(),
            'team_id' => Filament::getTenant()->id,
        ]);

        return response()->json([
            'code' => 200,
            'data' => $token,
            'message' => 'Token added successfully',
        ]);
    }

    public function updateStatus(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|string|in:' . TokenStatuses::NEW . ',' . TokenStatuses::DUMPED_FAILED . ',' . TokenStatuses::DUMPED_SUCCESS,
        ]);

        if (!auth()->user()->can('update Token')) {
            return response()->json([
                'code' => 403,
                'data' => null,
                'message' => 'Can not update this token',
            ], 403);
        }

        $token = Token::whereId($id)->whereTeamId(Filament::getTenant()->id)->first();

        // Check if the token not found then return 404
        if (!$token) {
            return response()->json([
                'code' => 404,
                'data' => null,
                'message' => 'Token not found',
            ], 400);
        }

        // Check if the current user is not TEAM_ADMIN and is not the owner of the token then return 403
        if (!auth()->user()->hasRole(DefaultRoles::TEAM_ADMIN) && $token->owner_id !== auth()->id()) {
            return response()->json([
                'code' => 403,
                'data' => null,
                'message' => 'Can not update this token',
            ], 403);
        }

        $token->update([
            'status' => $validatedData['status'],
        ]);

        return response()->json([
            'code' => 200,
            'message' => 'Token status updated successfully',
        ]);
    }
}
