<?php

declare(strict_types=1);

namespace JsonApi\Resource;

interface ResourceIdentifiersCollectionInterface
{
    /**
     * @return ResourceIdentifierInterface[]
     */
    public function resources(): array;
}
