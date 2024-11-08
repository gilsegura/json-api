<?php

declare(strict_types=1);

namespace JsonApi\Request;

use ProxyAssert\Assertion;

final readonly class Sort
{
    private const string ASC = 'ASC';

    private const string DESC = 'DESC';

    private const array SORT = [
        self::ASC,
        self::DESC,
    ];

    public string $order;

    private function __construct(
        public string $attribute,
        string $order,
    ) {
        Assertion::inArray($order, self::SORT);

        $this->order = $order;
    }

    public static function asc(string $attribute): self
    {
        return new self($attribute, self::ASC);
    }

    public static function desc(string $attribute): self
    {
        return new self($attribute, self::DESC);
    }
}
