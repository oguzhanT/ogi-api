<?php

namespace App\Http\Repositories;

use App\OperatingSystem;
use Illuminate\Http\Request;

class OperatingSystemRepository
{
    public function getOperatingSystemByName(string $name): ?OperatingSystem
    {
        return OperatingSystem::where('name', $name)->first();
    }

    public function findOrCreateOperatingSystem(string $name): OperatingSystem
    {
        if (strpos(mb_strtolower($name), OperatingSystem::ANDROID) !== false) {
            $type = OperatingSystem::ANDROID;
        } elseif (strpos(mb_strtolower($name), OperatingSystem::IOS) !== false) {
            $type = OperatingSystem::IOS;
        } else {
            $type = OperatingSystem::OTHER;
        }
        return OperatingSystem::firstOrCreate([
            'name' => $name,
            'type' => $type
        ]);
    }
}
