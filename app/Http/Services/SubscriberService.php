<?php


namespace App\Http\Services;

class SubscriberService
{
    /**
     * @var ProviderInterface $provider
     */
    protected $provider;

    public function __construct(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    public function subscribe(array $params): array
    {
        $response = $this->provider->checkSubscribe($params['receipt']);
        return json_decode($response->content(), true);
    }
}
