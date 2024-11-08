<?php

declare(strict_types=1);

namespace JsonApi\Resource;

interface ResourcesCollectionInterface
{
    /**
     * @return ResourceInterface[]
     */
    public function resources(): array;
}
