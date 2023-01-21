<?php

namespace JiriSmach\FaynSmsApi\Request;

use DateTimeInterface;

class ReceivedSmsListRequest extends ReceivedSmsRequest
{
    private ?int $pageSize = null;
    private ?int $page = null;
    private ?DateTimeInterface $datetimeFrom = null;
    private ?DateTimeInterface $datetimeTo = null;
    private ?int $messageId = null;
    private ?string $id = null;
    private ?string $source = null;
    private ?int $cid = null;

    public function __construct(
        ?int $pageSize,
        ?int $page,
        ?DateTimeInterface $datetimeFrom,
        ?DateTimeInterface $datetimeTo,
        ?int $messageId,
        ?string $id,
        ?string $source,
        ?int $cid
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

    public function getMethod(): string
    {
        return parent::getMethod() . 'list';
    }

    /**
     * @return array
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
            $params['timeFrom'] = $this->datetimeFrom->format(DateTimeInterface::ATOM);
        }
        if ($this->datetimeTo) {
            $params['timeTo'] = $this->datetimeTo->format(DateTimeInterface::ATOM);
        }

        return $params;
    }
}