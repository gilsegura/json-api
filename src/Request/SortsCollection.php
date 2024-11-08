<?php

declare(strict_types=1);

namespace JsonApi\Request;

use Serializer\SerializableInterface;

final readonly class SortsCollection implements SerializableInterface
{
    /** @var Sort[] */
    public array $sorts;

    public function __construct(Sort ...$sorts)
    {
        $this->sorts = $sorts;
    }

    #[\Override]
    public static function deserialize(array $data): self
    {
        return new self(...array_map(
            static fn (string $attribute, string $order): Sort => Sort::{$order}($attribute),
            array_keys($data), $data
        ));
    }

    #[\Override]
    public function serialize(): array
    {
        return array_combine(
            array_map(static fn (Sort $sorts): string => $sorts->attribute, $this->sorts),
            array_map(static fn (Sort $sorts): string => $sorts->order, $this->sorts)
        );
    }
}
