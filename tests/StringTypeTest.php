<?php

declare(strict_types=1);

namespace PandaLeague\JsonSchemaBuilder\Tests;

use InvalidArgumentException;
use PandaLeague\JsonSchemaBuilder\Factory;
use PHPUnit\Framework\TestCase;

final class StringTypeTest extends TestCase
{
    public function testBuildsFullStringSchema(): void
    {
        $schema = Factory::str()
            ->title('Username')
            ->description('A user identifier')
            ->size(3, 32)
            ->pattern('^[a-z]+$')
            ->format('email')
            ->default('admin')
            ->enum(['admin', 'user'])
            ->nullable(true)
            ->toArray();

        $this->assertEquals([
            'type'        => 'string',
            'title'       => 'Username',
            'description' => 'A user identifier',
            'default'     => 'admin',
            'enum'        => ['admin', 'user'],
            'nullable'    => true,
            'minLength'   => 3,
            'maxLength'   => 32,
            'pattern'     => '^[a-z]+$',
            'format'      => 'email',
        ], $schema);
    }

    public function testEnumRejectsNonStringValues(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Factory::str()->enum(['ok', 42]);
    }
}
