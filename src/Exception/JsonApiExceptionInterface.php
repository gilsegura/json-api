<?php

declare(strict_types=1);

namespace JsonApi\Exception;

use JsonApi\Error\Error;
use JsonApi\Meta\Meta;

interface JsonApiExceptionInterface extends \Throwable
{
    /**
     * @return Error[]
     */
    public function errors(): array;

    /**
     * @return Meta[]
     */
    public function meta(): array;
}
