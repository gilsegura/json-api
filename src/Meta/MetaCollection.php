<?php

declare(strict_types=1);

namespace JsonApi\Meta;

use Serializer\SerializableInterface;

final readonly class MetaCollection implements SerializableInterface
{
    /** @var Meta[] */
    public array $meta;

    public function __construct(Meta ...$meta)
    {
        $this->meta = $meta;
    }

    #[\Override]
    public static function deserialize(array $data): self
    {
        return new self(...array_map(
            static fn (string $name, mixed $value): Meta => Meta::kv($name, $value),
            array_keys($data), $data
        ));
    }

    #[\Override]
    public function serialize(): array
    {
        return array_combine(
            array_map(static fn (Meta $meta): string => $meta->name, $this->meta),
            array_map(static fn (Meta $meta): mixed => $meta->value, $this->meta)
        );
    }
}
