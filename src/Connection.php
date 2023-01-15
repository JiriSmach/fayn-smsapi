<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Utils;
use JiriSmach\FaynSmsApi\Exceptions\LoginException;
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
     * @param RequestInterface $requestInterface
     * @return ResponseInterface
     * @throws GuzzleException
     * @throws ClientException
     * @throws ServerException
     * @throws LoginException
     */
    public function getRequest(RequestInterface $requestInterface): ResponseInterface
    {
        $this->checkLogin();
        $client = new Client();
        $request = $this->createRequest('GET', $requestInterface);

        return $client->send($request);
    }

    /**
     * @param RequestInterface $requestInterface
     * @return ResponseInterface
     * @throws GuzzleException
     * @throws ClientException
     * @throws ServerException
     * @throws LoginException
     */
    public function postRequest(RequestInterface $requestInterface): ResponseInterface
    {
        $this->checkLogin();
        $client = new Client();
        $request = $this->createRequest('POST', $requestInterface);

        return $client->send($request);
    }

    /**
     * @param RequestInterface $requestInterface
     * @return ResponseInterface
     * @throws GuzzleException
     * @throws ClientException
     * @throws ServerException
     * @throws LoginException
     */
    public function patchRequest(RequestInterface $requestInterface): ResponseInterface
    {
        $this->checkLogin();
        $client = new Client();
        $request = $this->createRequest('PATCH', $requestInterface);

        return $client->send($request);
    }

    /**
     * @param string $requestMethod
     * @param RequestInterface $requestInterface
     * @return Request
     * @throws ClientException
     * @throws ServerException
     * @return Request
     */
    private function createRequest(string $requestMethod, RequestInterface $requestInterface): Request
    {
        $headers = [
            'Accept' => 'application/json',
            'content-type' => 'application/json'
        ];
        if ($this->token) {
            $headers['Authorization'] = 'Bearer ' . $this->token;
        }
        $body = $requestInterface->getBodyJson();

        return new Request(
            $requestMethod,
            $this->getUrl($requestInterface),
            $headers,
            $body
        );
    }

    /**
     * @return void
     * @throws ClientException
     * @throws ServerException
     * @throws LoginException
     * @throws GuzzleException
     */
    private function checkLogin(): void
    {
        if (is_null($this->token)) {
            $client = new Client();

            $loginRequest = new LoginRequest($this->username, $this->password);
            $request = $this->createRequest('POST', $loginRequest);

            $response = $client->send($request);
            if ($response->getStatusCode() === 200) {
                $responseArray = Utils::jsonDecode($response->getBody()->getContents(), true);
                if (isset($responseArray['token'])) {
                    $this->token = $responseArray['token'];
                } else {
                    $message = 'Token error';
                    throw new LoginException($message);
                }
            } else {
                $message = 'Login error';
                if (isset($responseArray['message'])) {
                    $message .= ': ' . $responseArray['message'];
                }
                throw new LoginException($message, $response->getStatusCode());
            }
        }
    }

    /**
     * @param RequestInterface $requestInterface
     * @return string
     */
    private function getUrl(RequestInterface $requestInterface): string
    {
        $url = str_replace('%method%', $requestInterface->getMethod(), self::URL);
        $url_parts = parse_url($url);
        $params = $requestInterface->getUrlParams();
        if (isset($url_parts['query'])) {
            parse_str($url_parts['query'], $params);
        }

        $url_parts['query'] = http_build_query($params);

        return $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'] . '?' . $url_parts['query'];
    }
}
