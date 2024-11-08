<?php

declare(strict_types=1);

namespace JsonApi\Request;

final readonly class Pagination
{
    private function __construct(
        public int $size,
        public int $offset,
    ) {
    }

    public static function pagination(
        int $size,
        int $offset,
    ): self {
        return new self(
            $size,
            $offset
        );
    }
}
