<?php
namespace App\Http\Controllers;

use App\Http\Repositories\ApplicationRepository;
use App\Http\Repositories\DeviceRepository;
use App\Http\Repositories\LanguageRepository;
use App\Http\Repositories\OperatingSystemRepository;
use App\Http\Requests\DeviceRequest;
use Illuminate\Http\JsonResponse;

class DeviceController extends Controller
{

    /**
     * @var DeviceRepository
     */
    private $deviceRepository;
    /**
     * @var ApplicationRepository
     */
    private $applicationRepository;
    /**
     * @var OperatingSystemRepository
     */
    private $operatingSystemRepository;
    /**
     * @var LanguageRepository
     */
    private $languageRepository;

    public function __construct(
        DeviceRepository $deviceRepository,
        ApplicationRepository $applicationRepository,
        OperatingSystemRepository $operatingSystemRepository,
        LanguageRepository $languageRepository
    ) {
        $this->deviceRepository = $deviceRepository;
        $this->applicationRepository = $applicationRepository;
        $this->operatingSystemRepository = $operatingSystemRepository;
        $this->languageRepository = $languageRepository;
    }

    public function register(DeviceRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $app = $this->applicationRepository->getApplicationByKey($validated['app_key']);

        if (!$app) {
            return response()->json([
                'message' => trans('api.app_not_exist')], 404);
        }

        $device = $this->deviceRepository->getDevice($validated['uid'], $app->id);

        if (!$device) {
            $language = $this->languageRepository->findOrCreateLanguage($validated['language']);
            $os = $this->operatingSystemRepository->findOrCreateOperatingSystem($validated['os']);
            $device = $this->deviceRepository->createDevice($validated['uid'], $app, $language, $os);
        }

        return response()->json([
           'message' => 'OK',
           'client-token' => $device->token,
        ]);
    }
}
