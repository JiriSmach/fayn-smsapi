<?php

declare(strict_types=1);

namespace JiriSmach\FaynSmsApi\Request;

use DateTimeInterface;

class ReceivedSmsListRequest extends ReceivedSmsRequest
{
    private ?int $pageSize;
    private ?int $page;
    private ?DateTimeInterface $datetimeFrom;
    private ?DateTimeInterface $datetimeTo;
    private ?int $messageId;
    private ?string $id;
    private ?string $source;
    private ?int $cid;

    public function __construct(
        ?int $pageSize,
        ?int $page,
        ?DateTimeInterface $datetimeFrom,
        ?DateTimeInterface $datetimeTo,
        ?int $messageId,
        ?string $id,
        ?string $source,
        ?int $cid,
    ) {
        $this->pageSize = $pageSize;
        $this->page = $page;
        $this->datetimeFrom = $datetimeFrom;
        $this->datetimeTo = $datetimeTo;
        $this->messageId = $messageId;
        $this->id = $id;
        $this->source = $source;
        $this->cid = $cid;
    }

    public function getBodyJson(): string
    {
        return '';
    }

    public function getPath(): string
    {
        return parent::getPath() . 'list';
    }

    /**
     * @return array<string, string>
     */
    public function getUrlParams(): array
    {
        $params = [];
        if ($this->pageSize) {
            $params['pageSize'] = $this->pageSize;
        }
        if ($this->page) {
            $params['page'] = $this->page;
        }
        if ($this->messageId) {
            $params['messageId'] = $this->messageId;
        }
        if ($this->id) {
            $params['externalId'] = $this->id;
        }
        if ($this->source) {
            $params['source'] = $this->source;
        }
        if ($this->cid) {
            $params['cid'] = $this->cid;
        }
        if ($this->datetimeFrom) {
            $params['timeFrom'] = $this->datetimeFrom->format(Connection::DATETIMEFORMAT);
        }
        if ($this->datetimeTo) {
            $params['timeTo'] = $this->datetimeTo->format(Connection::DATETIMEFORMAT);
        }

        return $params;
    }

    public function getMethod(): string
    {
        return self::METHOD_GET;
    }
}
