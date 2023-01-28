<?php

declare(strict_types=1);

namespace JiriSmach\FaynSmsApi;

interface RequestInterface
{
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PATCH = 'PATCH';
    public const METHOD_DELETE = 'DELETE';

    public function getBodyJson(): string;

    public function getPath(): string;

    public function getMethod(): string;

    /**
     * @return array<string, string>
     */
    public function getUrlParams(): array;

    /**
     * @return array<string, array<string, mixed>>
     */
    public function getData(): array;
}
