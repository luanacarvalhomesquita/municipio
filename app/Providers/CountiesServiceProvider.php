<?php

namespace App\Providers;

use App\Services\CountiesServiceBrasilAPI;
use App\Services\CountiesServiceIBGE;
use App\Services\CountiesServiceInterface;
use Illuminate\Support\ServiceProvider;

class CountiesServiceProvider extends ServiceProvider
{
    private const BRASIL_API = 'brasilapi';
    private const IBGE = 'ibge';

    private const PROVIDER_MAPPING = [
        self::BRASIL_API => CountiesServiceBrasilAPI::class,
        self::IBGE => CountiesServiceIBGE::class,
    ];

    public function register()
    {
        $this->app->bind(CountiesServiceInterface::class, function ($app) {
            $provider = $this->getCountyApiProvider();

            if (!array_key_exists($provider, self::PROVIDER_MAPPING)) {
                throw new \Exception("Tipo de API desconhecida: $provider");
            }

            $serviceClass = self::PROVIDER_MAPPING[$provider];
            return new $serviceClass;
        });
    }

    private function getCountyApiProvider(): string
    {
        return env('TYPE_COUNTY_API_PROVIDER');
    }
}
