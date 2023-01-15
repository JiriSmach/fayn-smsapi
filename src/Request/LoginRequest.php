<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi\Request;

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

    public function getBodyJson(): string
    {
        return \GuzzleHttp\json_encode([
            'username' => $this->username,
            'password' => $this->password
        ]);
    }

    public function getUrlParams(): array
    {
        return [];
    }
}
