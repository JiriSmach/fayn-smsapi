<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

class Connection
{
    private string $url;
    private string $apiToken;
    private array $urlParams = [];
    private const URL = 'https://smsapi.fayn.cz/mex/%method%';

    public function __construct(
        string $method
    ) {
        $this->url = str_replace('%method%', $method, self::URL);;
    }

    /**
     * @return ResponseInterface
     * @throws ClientException
     * @throws ServerException
     */
    public function getRequest(): ResponseInterface
    {
        $client = new Client();
        $request = $this->createRequest('GET');

        return $client->send($request);
    }

    public function postRequest(AbstractEmail $emailInterfaces): ResponseInterface
    {
        $client = new Client();
        $request = $this->createRequest('POST', $emailInterfaces);

        return $client->send($request);
    }

    private function createRequest(string $method, ?AbstractEmail $emailInterfaces = null): Request
    {
        return new Request(
            $method,
            $this->getUrl(),
            null,
            $emailInterfaces ? $emailInterfaces->getJson() : null
        );
    }
}
