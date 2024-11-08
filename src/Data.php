<?php

declare(strict_types=1);

namespace JsonApi;

use JsonApi\Attribute\AttributesCollection;
use JsonApi\Link\LinksCollection;
use JsonApi\Meta\MetaCollection;
use JsonApi\Relationship\RelationshipsCollection;
use JsonApi\Resource\ResourceIdentifierInterface;
use JsonApi\Resource\ResourceInterface;
use Serializer\SerializableInterface;

final readonly class Data implements SerializableInterface
{
    private function __construct(
        public string $id,
        public string $type,
        public ?AttributesCollection $attributes = null,
        public ?RelationshipsCollection $relationships = null,
        public ?LinksCollection $links = null,
        public ?MetaCollection $meta = null,
    ) {
    }

    public static function fromResource(ResourceInterface|ResourceIdentifierInterface $resource): self
    {
        if ($resource instanceof ResourceIdentifierInterface) {
            return new self(
                $resource->id(),
                $resource->type(),
            );
        }

        return new self(
            $resource->id(),
            $resource->type(),
            $resource->attributes(),
            $resource->relationships(),
            $resource->links(),
            $resource->meta(),
        );
    }

    #[\Override]
    public static function deserialize(array $data): self
    {
        return new self(
            $data['id'],
            $data['type'],
            isset($data['attributes']) ? AttributesCollection::deserialize($data['attributes']) : null,
            isset($data['relationships']) ? RelationshipsCollection::deserialize($data['relationships']) : null,
            isset($data['links']) ? LinksCollection::deserialize($data['links']) : null,
            isset($data['meta']) ? MetaCollection::deserialize($data['meta']) : null,
        );
    }

    #[\Override]
    public function serialize(): array
    {
        return [
            'type' => $this->type,
            'id' => $this->id,
            ...$this->attributes instanceof AttributesCollection ? ['attributes' => $this->attributes->serialize()] : [],
            ...$this->relationships instanceof RelationshipsCollection ? ['relationships' => $this->relationships->serialize()] : [],
            ...$this->links instanceof LinksCollection ? ['links' => $this->links->serialize()] : [],
            ...$this->meta instanceof MetaCollection ? ['meta' => $this->meta->serialize()] : [],
        ];
    }
}
