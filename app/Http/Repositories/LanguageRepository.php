<?php

namespace App\Http\Repositories;

use App\Language;

class LanguageRepository
{
    public function getLanguageByLocale(string $locale): ?Language
    {
        return Language::where('locale', $locale)->first();
    }

    public function findOrCreateLanguage(string $locale): ?Language
    {
        return Language::firstOrCreate([
            'locale' => $locale
        ]);
    }
}
