<?php

declare(strict_types=1);

namespace JsonApi\Request;

use Serializer\SerializableInterface;

final readonly class FiltersCollection implements SerializableInterface
{
    /** @var Filter[] */
    public array $filter;

    public function __construct(Filter ...$filter)
    {
        $this->filter = $filter;
    }

    #[\Override]
    public static function deserialize(array $data): self
    {
        return new self(...array_map(
            static fn (string $name, mixed $value): Filter => Filter::kv($name, $value),
            array_keys($data), $data
        ));
    }

    #[\Override]
    public function serialize(): array
    {
        return array_combine(
            array_map(static fn (Filter $filter): string => $filter->name, $this->filter),
            array_map(static fn (Filter $filter): mixed => $filter->value, $this->filter)
        );
    }
}
