<?php

declare(strict_types=1);

namespace JsonApi\Link;

use ProxyAssert\Assertion;

final readonly class Link
{
    private const string SELF = 'self';

    private const string RELATED = 'related';

    private const string ABOUT = 'about';

    private const string FIRST = 'first';

    private const string LAST = 'last';

    private const string PREV = 'prev';

    private const string NEXT = 'next';

    private const array RESOURCE = [
        self::SELF,
        self::RELATED,
    ];

    private const array ERROR = [
        self::ABOUT,
    ];

    private const array PAGINATION = [
        self::FIRST,
        self::LAST,
        self::PREV,
        self::NEXT,
    ];

    public string $name;

    private function __construct(
        string $name,
        public string $href,
    ) {
        Assertion::inArray($name, [...self::RESOURCE, ...self::ERROR, ...self::PAGINATION]);

        $this->name = $name;
    }

    public static function self(string $href): self
    {
        return new self(self::SELF, $href);
    }

    public static function related(string $href): self
    {
        return new self(self::RELATED, $href);
    }

    public static function about(string $href): self
    {
        return new self(self::ABOUT, $href);
    }

    public static function first(string $href): self
    {
        return new self(self::FIRST, $href);
    }

    public static function last(string $href): self
    {
        return new self(self::LAST, $href);
    }

    public static function prev(string $href): self
    {
        return new self(self::PREV, $href);
    }

    public static function next(string $href): self
    {
        return new self(self::NEXT, $href);
    }
}
