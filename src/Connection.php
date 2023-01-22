<?php
declare(strict_types=1);

namespace JiriSmach\FaynSmsApi;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Utils;
use JiriSmach\FaynSmsApi\Exceptions\LoginException;
use JiriSmach\FaynSmsApi\Request\LoginRequest;
use Psr\Http\Message\ResponseInterface;
use Throwable;
use SensitiveParameter;

class Connection
{
    private string $username;
    private string $password;
    private ?string $token = null;
    private const URL = 'https://smsapi.fayn.cz/mex/%method%';

    public function __construct(
        string $username,
        #[SensitiveParameter] string $password
    ) {
        $this->username = $username;
        $this->password = $password;

    }//end __construct()


    /**
     * @return bool
     */
    public function isLogin(): bool
    {
        try {
            $this->checkLogin();
        } catch (LoginException) {
            return false;
        }
        return true;
    }


    /**
     * @param RequestInterface $requestInterface
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function doRequest(RequestInterface $requestInterface): ResponseInterface
    {
        $this->checkLogin();
        $client = new Client();
        $request = $this->getRequest($requestInterface);
        return $client->send($request);
    }

    /**
     * @param RequestInterface $requestInterface
     * @return Request
     */
    private function getRequest(RequestInterface $requestInterface): Request
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
            $requestInterface->getMethod(),
            $this->getUrl($requestInterface),
            $headers,
            $body
        );
    }

    /**
     * @return void
     * @throws LoginException
     */
    private function checkLogin(): void
    {
        if (is_null($this->token)) {
            $loginRequest = new LoginRequest($this->username, $this->password);

            try {
                $client = new Client();
                $request = $this->getRequest($loginRequest);
                $response = $client->send($request);
                $responseArray = Utils::jsonDecode($response->getBody()->getContents(), true);
                if (isset($responseArray['token'])) {
                    $this->token = $responseArray['token'];
                } else {
                    $message = 'Token error';
                    throw new LoginException($message);
                }
            } catch (Throwable $e) {
                if ($e instanceof RequestException) {
                    $response = $e->getResponse()?->getBody()?->getContents();
                    $responseArray = Utils::jsonDecode($response ?: '', true);
                    $message = $responseArray['message'] ?? $e->getResponse()?->getReasonPhrase();
                    $code = $e->getResponse()?->getStatusCode();
                } else {
                    $code = $e->getCode();
                    $message = $e->getMessage();
                }
                throw new LoginException('Login error: ' . $message, $code, $e);
            }
        }
    }

    /**
     * @param RequestInterface $requestInterface
     * @return string
     */
    private function getUrl(RequestInterface $requestInterface): string
    {
        $url = str_replace('%method%', $requestInterface->getPath(), self::URL);
        $url_parts = parse_url($url);
        $params = $requestInterface->getUrlParams();
        if (isset($url_parts['query'])) {
            parse_str($url_parts['query'], $params);
        }

        $url_parts['query'] = http_build_query($params);

        return $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'] . '?' . $url_parts['query'];
    }
}
