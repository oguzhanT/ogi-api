<?php

namespace App\Http\Repositories;

use App\Application;
use App\Device;
use App\Language;
use App\OperatingSystem;
use Illuminate\Support\Str;

class DeviceRepository
{
    public function getDevice(string $uid, int $appId): ?Device
    {
        return Device::where('uid', $uid)->where('app_id', $appId)->first();
    }

    public function getDeviceByToken(string $token): ?Device
    {
        return Device::where('token', $token)->first();
    }

    public function createDevice(string $uid, Application $application, Language $language, OperatingSystem $operatingSystem): Device
    {
        $device = new Device();

        $device->uid = $uid;
        $device->app_id = $application->id;
        $device->language_id = $language->id;
        $device->os_id = $operatingSystem->id;
        $device->token = hash('sha256', Str::random(32));
        $device->save();

        return $device;
    }
}
