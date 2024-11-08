<?php

declare(strict_types=1);

namespace JsonApi\Tests;

use JsonApi\Error\Error;
use JsonApi\ErrorDocument;
use JsonApi\Link\Link;
use JsonApi\Meta\Meta;
use JsonApi\Source\Source;
use PHPUnit\Framework\TestCase;

final class ErrorDocumentTest extends TestCase
{
    private const array DOCUMENT = [
        'links' => [
            'about' => 'http://example.com/errors/409/0',
        ],
        'errors' => [
            [
                'status' => '409',
                'code' => '0',
                'title' => 'foo.bar.exception',
                'detail' => 'FooBarException',
                'source' => [
                    'pointer' => '/data/attributes/title',
                ],
            ],
        ],
        'meta' => [
            'copyright' => 'Copyright (c) 2024 https://github.com/gilsegura',
            'author' => 'https://github.com/gilsegura',
        ],
        'jsonapi' => [
            'version' => '1.1',
        ],
    ];

    public function test_must_document_serializable(): void
    {
        $document = ErrorDocument::deserialize(self::DOCUMENT);

        self::assertEquals(self::DOCUMENT, $document->serialize());
    }

    public function test_must_create_a_document(): void
    {
        $document = ErrorDocument::document(
            Error::error(
                '409',
                '0',
                'foo.bar.exception',
                'FooBarException',
            )
                ->withSource(
                    Source::pointer('/data/attributes/title')
                )
        )
            ->withLinks(
                Link::about('http://example.com/errors/409/0')
            )
            ->withMeta(
                Meta::kv('copyright', 'Copyright (c) 2024 https://github.com/gilsegura'),
                Meta::kv('author', 'https://github.com/gilsegura')
            )
            ->withJsonapi(
                Meta::kv('version', '1.1'),
            );

        self::assertEquals(self::DOCUMENT, $document->serialize());
    }
}
