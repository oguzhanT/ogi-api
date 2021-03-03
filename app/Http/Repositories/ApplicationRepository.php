<?php

namespace App\Http\Repositories;

use App\Application;

class ApplicationRepository
{
    public function getApplication(int $id): ?Application
    {
        return Application::where('id', $id)->firstOrFail();
    }

    public function getApplicationByKey(string $key): ?Application
    {
        return Application::where('key', $key)->first();
    }
}
