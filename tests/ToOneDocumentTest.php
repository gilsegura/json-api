<?php

declare(strict_types=1);

namespace JsonApi\Tests;

use JsonApi\Attribute\Attribute;
use JsonApi\Data;
use JsonApi\Link\Link;
use JsonApi\Meta\Meta;
use JsonApi\Relationship\ToManyRelationship;
use JsonApi\Relationship\ToOneRelationship;
use JsonApi\Resource\Resource;
use JsonApi\Resource\ResourceIdentifier;
use JsonApi\ToOneDocument;
use PHPUnit\Framework\TestCase;

final class ToOneDocumentTest extends TestCase
{
    private const array DOCUMENT = [
        'data' => [
            'type' => 'articles',
            'id' => '1',
            'attributes' => [
                'title' => 'JSON:API paints my bikeshed!',
            ],
            'relationships' => [
                'author' => [
                    'links' => [
                        'self' => 'http://example.com/articles/1/relationships/author',
                        'related' => 'http://example.com/articles/1/author',
                    ],
                    'data' => [
                        'type' => 'people',
                        'id' => '9',
                    ],
                ],
                'comments' => [
                    'links' => [
                        'self' => 'http://example.com/articles/1/relationships/comments',
                        'related' => 'http://example.com/articles/1/comments',
                    ],
                    'data' => [
                        [
                            'type' => 'comments',
                            'id' => '5',
                        ],
                        [
                            'type' => 'comments',
                            'id' => '12',
                        ],
                    ],
                ],
            ],
            'links' => [
                'self' => 'http://example.com/articles/1',
            ],
        ],
        'included' => [
            [
                'type' => 'people',
                'id' => '9',
                'attributes' => [
                    'firstName' => 'Dan',
                    'lastName' => 'Gebhardt',
                    'twitter' => 'dgeb',
                ],
                'links' => [
                    'self' => 'http://example.com/people/9',
                ],
            ],
            [
                'type' => 'comments',
                'id' => '5',
                'attributes' => [
                    'body' => 'First!',
                ],
                'relationships' => [
                    'author' => [
                        'data' => [
                            'type' => 'people',
                            'id' => '2',
                        ],
                    ],
                ],
                'links' => [
                    'self' => 'http://example.com/comments/5',
                ],
            ],
            [
                'type' => 'comments',
                'id' => '12',
                'attributes' => [
                    'body' => 'I like XML better',
                ],
                'relationships' => [
                    'author' => [
                        'data' => [
                            'type' => 'people',
                            'id' => '9',
                        ],
                    ],
                ],
                'links' => [
                    'self' => 'http://example.com/comments/12',
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
        $document = ToOneDocument::deserialize(self::DOCUMENT);

        self::assertEquals(self::DOCUMENT, $document->serialize());
    }

    public function test_must_create_a_document(): void
    {
        $document = ToOneDocument::document()
            ->withData(
                Data::fromResource(
                    Resource::resource('1', 'articles')
                        ->withAttributes(
                            Attribute::kv('title', 'JSON:API paints my bikeshed!')
                        )
                        ->withLink(
                            Link::self('http://example.com/articles/1')
                        )
                        ->withRelationships(
                            ToOneRelationship::relationship('author', ResourceIdentifier::resource('9', 'people'))
                                ->withLinks(
                                    Link::self('http://example.com/articles/1/relationships/author'),
                                    Link::related('http://example.com/articles/1/author')
                                ),
                            ToManyRelationship::relationship('comments', [
                                ResourceIdentifier::resource('5', 'comments'),
                                ResourceIdentifier::resource('12', 'comments'),
                            ])
                                ->withLinks(
                                    Link::self('http://example.com/articles/1/relationships/comments'),
                                    Link::related('http://example.com/articles/1/comments')
                                ),
                        )
                )
            )
            ->withIncluded(
                Resource::resource('9', 'people')
                    ->withAttributes(
                        Attribute::kv('firstName', 'Dan'),
                        Attribute::kv('lastName', 'Gebhardt'),
                        Attribute::kv('twitter', 'dgeb')
                    )
                    ->withLink(
                        Link::self('http://example.com/people/9')
                    ),
                Resource::resource('5', 'comments')
                    ->withAttributes(
                        Attribute::kv('body', 'First!')
                    )
                    ->withRelationships(
                        ToOneRelationship::relationship('author', ResourceIdentifier::resource('2', 'people'))
                    )
                    ->withLink(
                        Link::self('http://example.com/comments/5')
                    ),
                Resource::resource('12', 'comments')
                    ->withAttributes(
                        Attribute::kv('body', 'I like XML better')
                    )
                    ->withRelationships(
                        ToOneRelationship::relationship('author', ResourceIdentifier::resource('9', 'people'))
                    )
                    ->withLink(
                        Link::self('http://example.com/comments/12')
                    )
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
