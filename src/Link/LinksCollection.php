<?php

declare(strict_types=1);

namespace JsonApi\Link;

use Serializer\SerializableInterface;

final readonly class LinksCollection implements SerializableInterface
{
    /** @var Link[] */
    public array $links;

    public function __construct(Link ...$links)
    {
        $this->links = $links;
    }

    #[\Override]
    public static function deserialize(array $data): self
    {
        return new self(...array_map(
            static fn (string $name, mixed $href): Link => Link::{$name}($href),
            array_keys($data), $data
        ));
    }

    #[\Override]
    public function serialize(): array
    {
        return array_combine(
            array_map(static fn (Link $link): string => $link->name, $this->links),
            array_map(static fn (Link $link): string => $link->href, $this->links)
        );
    }
}
