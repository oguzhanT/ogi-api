<?php


namespace App\Http\Services;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class GoogleService implements ProviderInterface
{
    public function checkSubscribe(string $receipt): JsonResponse
    {
        $lastChar = substr($receipt, -1);

        if (is_numeric($lastChar) && $lastChar % 2 != 0) {
            return response()->json([
                'message' => 'OK',
                'status' => true,
                'expire-date' => Carbon::now()->addYear()->setTimezone('America/New_York')->format('Y-m-d H:i:s'),
            ]);
        }

        return response()->json([
            'error' => trans('api.invalid_purchase'),
        ]);
    }
}
