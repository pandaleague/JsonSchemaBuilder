<?php

declare(strict_types=1);

namespace PandaLeague\JsonSchemaBuilder\Tests;

use InvalidArgumentException;
use PandaLeague\JsonSchemaBuilder\Factory;
use PHPUnit\Framework\TestCase;

final class BaseTypeTest extends TestCase
{
    public function testRefIsRenderedWithDollarPrefix(): void
    {
        $schema = Factory::obj()->ref('#/definitions/user')->toArray();

        $this->assertEquals([
            'type' => 'object',
            '$ref' => '#/definitions/user',
        ], $schema);
    }

    public function testCombinatorsAcceptOnlyTypeInstances(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Factory::str()->anyOf([Factory::str(), 'oops']);
    }

    public function testLinkRejectsUnknownRel(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Factory::obj()->link('unknown', '/path');
    }

    public function testLinkAppendsValidEntries(): void
    {
        $schema = Factory::obj()
            ->link('self', '/widgets/{id}')
            ->link('collection', '/widgets', 'All widgets', 'GET')
            ->toArray();

        $this->assertEquals([
            ['rel' => 'self', 'href' => '/widgets/{id}', 'title' => '', 'method' => 'GET'],
            ['rel' => 'collection', 'href' => '/widgets', 'title' => 'All widgets', 'method' => 'GET'],
        ], $schema['links']);
    }
}
