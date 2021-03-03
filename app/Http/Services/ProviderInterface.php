<?php
namespace App\Http\Services;

use Illuminate\Http\JsonResponse;

interface ProviderInterface
{
    public function checkSubscribe(string $receipt): JsonResponse;
}
