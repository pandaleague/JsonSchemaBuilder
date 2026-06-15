<?php

declare(strict_types=1);

namespace PandaLeague\JsonSchemaBuilder\Tests;

use InvalidArgumentException;
use PandaLeague\JsonSchemaBuilder\Factory;
use PHPUnit\Framework\TestCase;

final class NumberTypeTest extends TestCase
{
    public function testBuildsRangedNumberSchema(): void
    {
        $schema = Factory::num()
            ->minimum(0.5, true)
            ->maximum(10.0)
            ->multipleOf(0.5)
            ->default(1.0)
            ->toArray();

        $this->assertEquals([
            'type'             => 'number',
            'default'          => 1.0,
            'multipleOf'       => 0.5,
            'minimum'          => 0.5,
            'maximum'          => 10.0,
            'exclusiveMinimum' => true,
        ], $schema);
    }

    public function testEnumRejectsNonNumericValues(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Factory::num()->enum([1, 'two']);
    }
}
