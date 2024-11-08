<?php

declare(strict_types=1);

namespace JsonApi\Resource;

interface ResourceIdentifierInterface
{
    public function id(): string;

    public function type(): string;
}
