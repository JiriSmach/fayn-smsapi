<?php

declare(strict_types=1);

namespace JiriSmach\FaynSmsApi\Request;

use GuzzleHttp\Utils;
use JiriSmach\FaynSmsApi\RequestInterface;

class LoginRequest implements RequestInterface
{
    private string $username;
    private string $password;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getBodyJson(): string
    {
        return Utils::jsonEncode([
            'username' => $this->username,
            'password' => $this->password,
        ]);
    }

    /**
     * @return array<string, string>
     */
    public function getUrlParams(): array
    {
        return [];
    }

    public function getPath(): string
    {
        return 'login';
    }

    public function getMethod(): string
    {
        return self::METHOD_POST;
    }
}
