<?php

declare(strict_types=1);

namespace JsonApi\Relationship;

use JsonApi\Link\Link;
use JsonApi\Link\LinksCollection;
use JsonApi\Meta\Meta;
use JsonApi\Meta\MetaCollection;
use JsonApi\Resource\ResourceIdentifier;
use JsonApi\Resource\ResourceIdentifiersCollection;

final readonly class ToManyRelationship implements RelationshipInterface
{
    private function __construct(
        public string $name,
        public ResourceIdentifiersCollection $data,
        public ?LinksCollection $links = null,
        public ?MetaCollection $meta = null,
    ) {
    }

    /**
     * @param ResourceIdentifier[] $data
     */
    public static function relationship(
        string $name,
        array $data,
    ): self {
        return new self(
            $name,
            new ResourceIdentifiersCollection(...$data)
        );
    }

    public function withLinks(Link ...$links): self
    {
        return new self(
            $this->name,
            $this->data,
            new LinksCollection(...$links),
            $this->meta
        );
    }

    public function withMeta(Meta ...$meta): self
    {
        return new self(
            $this->name,
            $this->data,
            $this->links,
            new MetaCollection(...$meta)
        );
    }

    #[\Override]
    public static function deserialize(array $data): self
    {
        return new self(
            (string) key($data),
            ResourceIdentifiersCollection::deserialize($data[(string) key($data)]['data']),
            isset($data[(string) key($data)]['links']) ? LinksCollection::deserialize($data[(string) key($data)]['links']) : null,
            isset($data[(string) key($data)]['meta']) ? MetaCollection::deserialize($data[(string) key($data)]['meta']) : null,
        );
    }

    #[\Override]
    public function serialize(): array
    {
        return [
            $this->name => [
                ...$this->links instanceof LinksCollection ? ['links' => $this->links->serialize()] : [],
                'data' => $this->data->serialize(),
                ...$this->meta instanceof MetaCollection ? ['meta' => $this->meta->serialize()] : [],
            ],
        ];
    }
}
