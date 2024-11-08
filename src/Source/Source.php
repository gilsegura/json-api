<?php

declare(strict_types=1);

namespace JsonApi\Source;

use ProxyAssert\Assertion;

final readonly class Source
{
    private const string POINTER = 'pointer';

    private const string PARAMETER = 'parameter';

    public string $name;

    private function __construct(
        string $name,
        public string $value,
    ) {
        Assertion::inArray($name, [self::POINTER, self::PARAMETER]);

        $this->name = $name;
    }

    public static function pointer(string $pointer): self
    {
        return new self(
            self::POINTER,
            $pointer
        );
    }

    public static function parameter(string $pointer): self
    {
        return new self(
            self::PARAMETER,
            $pointer
        );
    }
}
