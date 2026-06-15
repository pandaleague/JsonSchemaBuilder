<?php

declare(strict_types=1);

namespace PandaLeague\JsonSchemaBuilder\Tests;

use InvalidArgumentException;
use PandaLeague\JsonSchemaBuilder\Factory;
use PHPUnit\Framework\TestCase;

final class ArrayTypeTest extends TestCase
{
    public function testBuildsArrayOfStrings(): void
    {
        $schema = Factory::arr()
            ->items(Factory::str())
            ->size(1, 3)
            ->uniqueItems(true)
            ->toArray();

        $this->assertEquals([
            'type'        => 'array',
            'items'       => ['type' => 'string'],
            'minItems'    => 1,
            'maxItems'    => 3,
            'uniqueItems' => true,
        ], $schema);
    }

    public function testSizeRejectsNegativeBounds(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Factory::arr()->size(-1, 5);
    }

    public function testItemsRejectsNonTypeValues(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Factory::arr()->items('not-a-type');
    }
}
