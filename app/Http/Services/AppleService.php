<?php


namespace App\Http\Services;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class AppleService implements ProviderInterface
{
    public function checkSubscribe(string $receipt): JsonResponse
    {
        $lastChar = substr($receipt, -1);

        if (is_numeric($lastChar) && $lastChar % 2 != 0) {
            return response()->json([
               'message' => 'OK',
               'status' => true,
               'expire-date' => Carbon::now()->addMonths(6)->setTimezone('America/New_York')->format('Y-m-d H:i:s'),
           ]);
        }

        return response()->json([
            'message' => trans('api.invalid_purchase'),
        ], 404);
    }
}
