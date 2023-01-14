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

    private function createRequest(string $method, ?SmsEmail $smsInterfaces = null): Request
    {

        $headers = ['Accept' => 'application/json',];
        if ($this->token) {
            $headers['Authorization'] = 'Bearer ' . $this->token;
        }
        $body = $smsInterfaces ? $smsInterfaces->getBodyJson() : null;

        return new Request(
            $method,
            $this->getUrl(),
            null,
            [
                'headers' => $headers,
                'body' => $body,
            ]
        );
    }

    /**
     * @param array $urlParams
     * @return void
     */
    public function setUrlParams(array $urlParams): void
    {
        $this->urlParams = $urlParams;
    }

    /**
     * @return string
     */
    private function getUrl(): string
    {
        $this->url = str_replace('%method%', $method, self::URL);
        $url_parts = parse_url($this->url);
        if (isset($url_parts['query'])) {
            parse_str($url_parts['query'], $this->urlParams);
        }

        $url_parts['query'] = http_build_query($this->urlParams);

        return $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'] . '?' . $url_parts['query'];
    }
}
