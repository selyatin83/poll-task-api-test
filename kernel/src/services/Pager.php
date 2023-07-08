<?php

namespace Mselyatin\Question\services;

/**
 * @author <selyatin83@mail.ru>
 */
class Pager
{
    public const DEFAULT_PAGE = 1;
    public const DEFAULT_LIMIT = 10;

    public function __construct(
        public int $page = self::DEFAULT_PAGE,
        public int $limit = self::DEFAULT_LIMIT
    ) {
        if ($this->page < 0) {
            $this->page = self::DEFAULT_PAGE;
        }

        if ($this->limit < 0) {
            $this->limit = self::DEFAULT_LIMIT;
        }

        $this->page--;
    }

    /**
     * @param int|null $page
     * @param int|null $limit
     *
     * @return static
     */
    public static function create(?int $page, ?int $limit): static
    {
        $page = (null === $page || $page <= 0)
            ? self::DEFAULT_PAGE
            : $page;

        $limit = (null === $limit || $limit <= 0)
            ? self::DEFAULT_LIMIT
            : $limit;

        return new static($page, $limit);
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->getPage() * $this->getLimit();
    }
}
