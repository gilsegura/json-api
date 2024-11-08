<?php

declare(strict_types=1);

namespace JsonApi;

use JsonApi\Link\Link;
use JsonApi\Link\LinksCollection;
use JsonApi\Meta\Meta;
use JsonApi\Meta\MetaCollection;
use JsonApi\Resource\Resource;
use JsonApi\Resource\ResourcesCollection;

final readonly class ToOneDocument implements DocumentInterface
{
    private function __construct(
        public ?Data $data = null,
        public ?MetaCollection $meta = null,
        public ?MetaCollection $jsonapi = null,
        public ?LinksCollection $links = null,
        public ?ResourcesCollection $included = null,
    ) {
    }

    public static function document(?Data $data = null): self
    {
        return new self($data);
    }

    public function withMeta(Meta ...$meta): self
    {
        return new self(
            $this->data,
            new MetaCollection(...$meta),
            $this->jsonapi,
            $this->links,
            $this->included
        );
    }

    public function withData(Data $data): self
    {
        return new self(
            $data,
            $this->meta,
            $this->jsonapi,
            $this->links,
            $this->included
        );
    }

    public function withJsonapi(Meta ...$jsonapi): self
    {
        return new self(
            $this->data,
            $this->meta,
            new MetaCollection(...$jsonapi),
            $this->links,
            $this->included
        );
    }

    public function withLinks(Link ...$links): self
    {
        return new self(
            $this->data,
            $this->meta,
            $this->jsonapi,
            new LinksCollection(...$links),
            $this->included
        );
    }

    public function withIncluded(Resource ...$included): self
    {
        return new self(
            $this->data,
            $this->meta,
            $this->jsonapi,
            $this->links,
            new ResourcesCollection(...$included)
        );
    }

    #[\Override]
    public static function deserialize(array $data): self
    {
        return new self(
            isset($data['data']) ? Data::deserialize($data['data']) : null,
            isset($data['meta']) ? MetaCollection::deserialize($data['meta']) : null,
            isset($data['jsonapi']) ? MetaCollection::deserialize($data['jsonapi']) : null,
            isset($data['links']) ? LinksCollection::deserialize($data['links']) : null,
            isset($data['included']) ? ResourcesCollection::deserialize($data['included']) : null,
        );
    }

    #[\Override]
    public function serialize(): array
    {
        return [
            ...$this->meta instanceof MetaCollection ? ['meta' => $this->meta->serialize()] : [],
            ...$this->jsonapi instanceof MetaCollection ? ['jsonapi' => $this->jsonapi->serialize()] : [],
            ...$this->links instanceof LinksCollection ? ['links' => $this->links->serialize()] : [],
            'data' => $this->data?->serialize(),
            ...$this->included instanceof ResourcesCollection ? ['included' => $this->included->serialize()] : [],
        ];
    }
}
