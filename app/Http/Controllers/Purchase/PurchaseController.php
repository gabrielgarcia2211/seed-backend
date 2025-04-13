<?php

namespace App\Http\Controllers\Purchase;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Purchase\PurchaseService;
use App\Http\Requests\Purchase\PurchaseRequest;

class PurchaseController extends Controller
{
    protected $purchaseService;

    public function __construct(PurchaseService $purchaseService)
    {
        $this->purchaseService = $purchaseService;
    }

    public function makePurchase(PurchaseRequest $request)
    {
        try {
            $this->purchaseService->handlePurchase($request->all());
            return response()->json([
                'message' => 'Compra registrada. Se envió el correo a ' . $request->email,
            ]);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
        }
    }
}
