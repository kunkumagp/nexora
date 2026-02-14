<?php

declare(strict_types=1);

namespace App\Modules\POS\Presentation\Http\Controllers;

use App\Modules\POS\Application\Services\PosService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class PosController
{
    protected PosService $posService;

    public function __construct(PosService $posService)
    {
        $this->posService = $posService;
    }

    public function addToCart(Request $request): JsonResponse
    {
        $cart = $this->posService->addToCart(Auth::user()->id, $request->all());
        return response()->json($cart);
    }

    public function updateCart(Request $request): JsonResponse
    {
        $cart = $this->posService->updateCart(Auth::user()->id, $request->all());
        return response()->json($cart);
    }

    public function checkout(Request $request): JsonResponse
    {
        try {
            $invoice = $this->posService->checkout(Auth::user()->id, $request->all());
            return response()->json($invoice, 201);
        } catch (\DomainException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function refund(Request $request): JsonResponse
    {
        try {
            $result = $this->posService->refund(Auth::user()->id, $request->all());
            return response()->json($result);
        } catch (\DomainException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function shiftOpen(Request $request): JsonResponse
    {
        $result = $this->posService->openShift(Auth::user()->id, $request->all());
        return response()->json($result);
    }

    public function shiftClose(Request $request): JsonResponse
    {
        $result = $this->posService->closeShift(Auth::user()->id, $request->all());
        return response()->json($result);
    }
}
