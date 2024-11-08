<?php

declare(strict_types=1);

namespace JsonApi\Attribute;

use Serializer\SerializableInterface;

final readonly class AttributesCollection implements SerializableInterface
{
    /** @var Attribute[] */
    public array $attributes;

    public function __construct(Attribute ...$attributes)
    {
        $this->attributes = $attributes;
    }

    #[\Override]
    public static function deserialize(array $data): self
    {
        return new self(...array_map(
            static fn (string $name, mixed $value): Attribute => Attribute::kv($name, $value),
            array_keys($data), $data
        ));
    }

    #[\Override]
    public function serialize(): array
    {
        return array_combine(
            array_map(static fn (Attribute $attribute): string => $attribute->name, $this->attributes),
            array_map(static fn (Attribute $attribute): mixed => $attribute->value, $this->attributes)
        );
    }
}
