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
    public function getRequest(string $method, RequestInterface $requestInterface): ResponseInterface
    {
        $this->checkLogin();
        $client = new Client();
        $request = $this->createRequest('GET', $method, $requestInterface);

        return $client->send($request);
    }

    public function postRequest(string $method, RequestInterface $requestInterface): ResponseInterface
    {
        $this->checkLogin();
        $client = new Client();
        $request = $this->createRequest('POST', $method, $requestInterfaces);

        return $client->send($request);
    }

    /**
     * @param string $requestMethod
     * @param string $method
     * @param RequestInterface|null $smsInterfaces
     * @return Request
     */
    private function createRequest(string $requestMethod, string $method, ?RequestInterface $requestInterface = null): Request
    {

        $headers = ['Accept' => 'application/json',];
        if ($this->token) {
            $headers['Authorization'] = 'Bearer ' . $this->token;
        }
        $body = $requestInterface ? $requestInterface->getBodyJson() : null;

        return new Request(
            $requestMethod,
            $this->getUrl($method, $requestInterface->getUrlParams),
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
     * @param string $key
     * @param string $urlParam
     * @return void
     */
    public function addUrlParams(string $key, string $urlParam): void
    {
        $this->urlParams[$key] = $urlParam;
    }

    /**
     * @param string $method
     * @return string
     */
    private function getUrl(string $method, array $urlParams = []): string
    {
        $url = str_replace('%method%', $method, self::URL);
        $url_parts = parse_url($url);
        if (isset($url_parts['query'])) {
            parse_str($url_parts['query'], $urlParams);
        }

        $url_parts['query'] = http_build_query($urlParams);

        return $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'] . '?' . $url_parts['query'];
    }
}
