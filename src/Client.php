<?php

namespace AimanDaniel\ToyyibPay;

use Laravie\Codex\Discovery;
use Http\Client\Common\HttpMethodsClient as HttpClient;

class Client extends \Laravie\Codex\Client
{
    /**
     * ToyyibPay API Key.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * ToyyibPay category code
     *
     * @var string
     */
    protected $categoryCode;

    /**
     * ToyyibPay API endpoint.
     *
     * @var string
     */
    protected $apiEndpoint = 'https://toyyibpay.com/index.php/api';

    /**
     * Default API version.
     *
     * @var string
     */
    protected $defaultVersion = 'v1';

    /**
     * List of supported API versions.
     *
     * @var array
     */
    protected $supportedVersions = [
        'v1' => 'One',
    ];

    /**
     * Sandbox mode status
     *
     * @var boolean
     */
    protected $isUsingSandbox = false;

    /**
     * Construct a new Billplz Client.
     */
    public function __construct(HttpClient $http, string $apiKey, string $categoryCode)
    {
        $this->http = $http;
        $this->setApiKey($apiKey);
        $this->setCategoryCode($categoryCode);
    }

    /**
     * Make a client.
     *
     * @return $this
     */
    public static function make(string $apiKey, string $categoryCode)
    {
        return new static(Discovery::client(), $apiKey, $categoryCode);
    }

    /**
     * Use sandbox environment.
     *
     * @return $this
     */
    final public function useSandbox(): self
    {
        $this->isUsingSandbox = true;

        return $this->useCustomApiEndpoint('https://dev.toyyibpay.com/index.php/api');
    }

    /**
     * Determine is using sandbox or not
     *
     * @return boolean
     */
    public function isUsingSandbox(): bool
    {
        return $this->isUsingSandbox;
    }

    /**
     * Get API Key.
     */
    final public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * Set API Key.
     *
     * @return $this
     */
    final public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Get the category code
     *
     * @return string
     */
    final public function getCategoryCode(): string
    {
        return $this->categoryCode;
    }

    /**
     * Set category code
     *
     * @param string $categoryCode
     * @return self
     */
    final public function setCategoryCode(string $categoryCode): self
    {
        $this->categoryCode = $categoryCode;

        return $this;
    }

    /**
     * Switch to admin API endpoint
     *
     * @return void
     */
    final public function useAdminApiEndpoint()
    {
        return $this->useCustomApiEndpoint(
            !$this->isUsingSandbox()
            ? 'https://toyyibpay.com/admin/api'
            : 'https://dev.toyyibpay.com/admin/api'
        );
    }

    /**
     * Get Bank resource
     *
     * @param string|null $version
     * @return \AimanDaniel\ToyyibPay\Contracts\Bank
     */
    final public function bank(?string $version = null): Contracts\Bank
    {
        return $this->uses('Bank', $version);
    }

    /**
     * Get Bill resource
     *
     * @param string|null $version
     * @return \AimanDaniel\ToyyibPay\Contracts\Bill
     */
    final public function bill(?string $version = null): Contracts\Bill
    {
        return $this->uses('Bill', $version);
    }

    /**
     * Get User resource
     *
     * @param string|null $version
     * @return \AimanDaniel\ToyyibPay\Contracts\User
     */
    final public function user(?string $version = null): Contracts\User
    {
        return $this->uses('User', $version);
    }

    /**
     * Get Category resource
     *
     * @param string|null $version
     * @return \AimanDaniel\ToyyibPay\Contracts\Category
     */
    final public function category(?string $version = null): Contracts\Category
    {
        return $this->uses('Category', $version);
    }

    /**
     * Get Package resource
     *
     * @param string|null $version
     * @return \AimanDaniel\ToyyibPay\Contracts\Package
     */
    final public function package(?string $version = null): Contracts\Package
    {
        return $this->uses('Package', $version);
    }

    /**
     * Get Settlement resource
     *
     * @param string|null $version
     * @return \AimanDaniel\ToyyibPay\Contracts\Settlement
     */
    final public function settlement(?string $version = null): Contracts\Settlement
    {
        return $this->uses('Settlement', $version);
    }

    /**
     * Get resource default namespace.
     */
    final protected function getResourceNamespace(): string
    {
        return __NAMESPACE__;
    }
}