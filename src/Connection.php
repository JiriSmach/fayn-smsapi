<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use JiriSmach\FaynSmsApi\Request\LoginRequest;
use Psr\Http\Message\ResponseInterface;

class Connection
{
    private string $username;
    private string $password;
    private ?string $token = null;
    private const URL = 'https://smsapi.fayn.cz/mex/%method%';

    public function __construct(
        string $username,
        string $password
    ) {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return ResponseInterface
     * @throws ClientException
     * @throws ServerException
     */
    public function getRequest(RequestInterface $requestInterface): ResponseInterface
    {
        $this->checkLogin();
        $client = new Client();
        $request = $this->createRequest('GET', $requestInterface);

        return $client->send($request);
    }

    public function postRequest(RequestInterface $requestInterface): ResponseInterface
    {
        $this->checkLogin();
        $client = new Client();
        $request = $this->createRequest('POST', $requestInterfaces);

        return $client->send($request);
    }

    /**
     * @param string $requestMethod
     * @param string $method
     * @param RequestInterface|null $smsInterfaces
     * @return Request
     */
    private function createRequest(string $requestMethod, RequestInterface $requestInterface): Request
    {

        $headers = ['Accept' => 'application/json',];
        if ($this->token) {
            $headers['Authorization'] = 'Bearer ' . $this->token;
        }
        $body = $requestInterface->getBodyJson();

        return new Request(
            $requestMethod,
            $this->getUrl($requestInterface),
            null,
            [
                'headers' => $headers,
                'body' => $body,
            ]
        );
    }

    /**
     * @return void
     */
    private function checkLogin(): void
    {
        if (is_null($this->token)) {
            $client = new Client();

            $loginRequest = new LoginRequest($this->username, $this->password);
            $request = $this->createRequest('POST', '/login', $loginRequest);

            $client->send($request);
        }
        //TODO: overeni přihlášení a dostani tokenu
    }

    /**
     * @param RequestInterface $requestInterface
     * @return string
     */
    private function getUrl(RequestInterface $requestInterface): string
    {
        $url = str_replace('%method%', $requestInterface->getMethod(), self::URL);
        $url_parts = parse_url($url);
        if (isset($url_parts['query'])) {
            parse_str($url_parts['query'], $requestInterface->getUrlParams());
        }

        $url_parts['query'] = http_build_query($urlParams);

        return $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'] . '?' . $url_parts['query'];
    }
}
