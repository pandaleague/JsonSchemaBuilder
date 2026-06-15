<?php

declare(strict_types=1);

namespace PandaLeague\JsonSchemaBuilder\Tests;

use InvalidArgumentException;
use PandaLeague\JsonSchemaBuilder\Factory;
use PHPUnit\Framework\TestCase;

final class ObjectTypeTest extends TestCase
{
    public function testBuildsObjectWithNestedProperties(): void
    {
        $schema = Factory::obj()
            ->property('name', Factory::str())
            ->property('age', Factory::num())
            ->required(['name'])
            ->additionalProperties(false)
            ->size(1, 5)
            ->propertyNames(Factory::str()->pattern('^[a-z]+$'))
            ->toArray();

        $this->assertEquals([
            'type'                 => 'object',
            'properties'           => [
                'name' => ['type' => 'string'],
                'age'  => ['type' => 'number'],
            ],
            'additionalProperties' => false,
            'required'             => ['name'],
            'minProperties'        => 1,
            'maxProperties'        => 5,
            'propertyNames'        => [
                'type'    => 'string',
                'pattern' => '^[a-z]+$',
            ],
        ], $schema);
    }

    public function testPropertyDependencyRequiresExistingProperties(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Factory::obj()
            ->property('a', Factory::str())
            ->propertyDependency('a', ['missing']);
    }

    public function testAdditionalPropertiesRejectsInvalidArgument(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Factory::obj()->additionalProperties('nope');
    }
}
