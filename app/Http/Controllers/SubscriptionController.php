<?php
namespace App\Http\Controllers;

use App\Http\Repositories\DeviceRepository;
use App\Http\Repositories\SubscriptionRepository;
use App\Http\Requests\PurchaseRequest;
use App\Http\Resources\SubscribeResource;
use App\Http\Services\AppleService;
use App\Http\Services\ProviderInterface;
use App\Http\Services\SubscriberService;
use App\OperatingSystem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    /**
     * @var DeviceRepository
     */
    private $deviceRepository;
    /**
     * @var SubscriptionRepository
     */
    private $subscriptionRepository;
    /**
     * @var ProviderInterface
     */
    private $provider;
    /**
     * @var SubscriberService
     */
    private $subscriberService;

    public function __construct(
        ProviderInterface $provider,
        DeviceRepository $deviceRepository,
        SubscriptionRepository $subscriptionRepository
    ) {
        $this->middleware('checkClientTokenIsValid');
        $this->deviceRepository = $deviceRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->provider = $provider;
    }

    public function purchase(PurchaseRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $device = $this->deviceRepository->getDeviceByToken($validated['client-token']);

        if (!$device) {
            return response()->json([
                'message' => trans('api.403_error_text')], 403);
        }

        if ($device->operatingSystem->type === OperatingSystem::IOS) {
            $service = new subscriberService(new AppleService());
        } elseif ($device->operatingSystem->type === OperatingSystem::ANDROID) {
            $service = new subscriberService(new AppleService());
        } else {
            return response()->json([
                'message' => trans('api.403_error_text')], 403);
        }

        $result = $service->subscribe($validated);

        if (isset($result['status']) && $result['status'] === true) {
            $activeSubscription = $this->subscriptionRepository->getActiveSubscription($device);

            if ($activeSubscription) {
                $subscription = $this->subscriptionRepository->renew($activeSubscription, $result['expire-date']);
            } else {
                $subscription = $this->subscriptionRepository->create($device, $result['expire-date'], $result['status']);
            }

            return response()->json(['data' => new SubscribeResource($subscription)]);
        } else {
            return response()->json([
                'error' => trans('api.invalid_purchase'),
            ]);
        }
    }

    public function checkSubscription(Request $request): JsonResponse
    {
        $device = $this->deviceRepository->getDeviceByToken($request->get('client-token'));
        if (!$device) {
            return response()->json([
                'message' => trans('api.403_error_text')], 403);
        }

        $subscription = $this->subscriptionRepository->getActiveSubscription($device);

        return response()->json(['data' => new SubscribeResource($subscription)]);
    }
}
