<?php

declare(strict_types=1);

namespace App\Libraries\CoinGecko;

use App\Libraries\CoinGecko\Api\Coins;
use App\Libraries\CoinGecko\Api\Contract;
use App\Libraries\CoinGecko\Api\Derivatives;
use App\Libraries\CoinGecko\Api\Events;
use App\Libraries\CoinGecko\Api\ExchangeRates;
use App\Libraries\CoinGecko\Api\Exchanges;
use App\Libraries\CoinGecko\Api\Finance;
use App\Libraries\CoinGecko\Api\Globals;
use App\Libraries\CoinGecko\Api\Indexes;
use App\Libraries\CoinGecko\Api\Ping;
use App\Libraries\CoinGecko\Api\Simple;
use App\Libraries\CoinGecko\Api\StatusUpdates;
use Exception;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Class CoinGeckoClient
 * @package App\Libraries\CoinGecko
 */
class CoinGeckoClient
{
    protected const BASE_URI = 'https://api.coingecko.com';

    /** @var Client */
    private $httpClient;

    /** @var ResponseInterface|null */
    protected $lastResponse;

    public function __construct($proxy, ?Client $client = null)
    {
        if ($proxy) {
            //proxy call
            $this->httpClient = $client ?: new Client(['base_uri' => self::BASE_URI,
                'timeout' => 240.0,
                'cookie' => true,
                'proxy' => env('PROXY', '164.92.202.73')]);
        }
    else{
        //regular call
                $this->httpClient = $client ?: new Client(['base_uri' => self::BASE_URI,
                'timeout' => 240.0,
                'cookie' => true]);
        }
    }

    public function getHttpClient(): Client
    {
        return $this->httpClient;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function ping(): array
    {
        return (new Ping($this))->ping();
    }

    public function simple(): Simple
    {
        return new Simple($this);
    }

    public function coins(): Coins
    {
        return new Coins($this);
    }

    public function contract(): Contract
    {
        return new Contract($this);
    }

    public function exchanges(): Exchanges
    {
        return new Exchanges($this);
    }

    public function finance(): Finance
    {
        return new Finance($this);
    }

    public function indexes(): Indexes
    {
        return new Indexes($this);
    }

    public function derivatives(): Derivatives
    {
        return new Derivatives($this);
    }

    public function statusUpdates(): StatusUpdates
    {
        return new StatusUpdates($this);
    }

    public function events(): Events
    {
        return new Events($this);
    }

    public function exchangeRates(): ExchangeRates
    {
        return new ExchangeRates($this);
    }

    public function globals(): Globals
    {
        return new Globals($this);
    }

    public function setLastResponse(ResponseInterface $response)
    {
        return $this->lastResponse = $response;
    }

    public function getLastResponse(): ?ResponseInterface
    {
        return $this->lastResponse;
    }
}
