<?php

declare(strict_types=1);

namespace JsonApi\Request;

use ProxyAssert\Assertion;

final readonly class Filter
{
    public string $name;

    private function __construct(
        string $name,
        public mixed $value,
    ) {
        Assertion::notEmpty($name);

        $this->name = $name;
    }

    public static function kv(
        string $name,
        mixed $value,
    ): self {
        return new self($name, $value);
    }
}
