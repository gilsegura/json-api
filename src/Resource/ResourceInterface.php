<?php

declare(strict_types=1);

namespace JsonApi\Resource;

use JsonApi\Attribute\AttributesCollection;
use JsonApi\Link\LinksCollection;
use JsonApi\Meta\MetaCollection;
use JsonApi\Relationship\RelationshipsCollection;

interface ResourceInterface
{
    public function id(): string;

    public function type(): string;

    public function attributes(): ?AttributesCollection;

    public function relationships(): ?RelationshipsCollection;

    public function links(): ?LinksCollection;

    public function meta(): ?MetaCollection;
}
