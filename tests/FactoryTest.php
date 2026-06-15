<?php

declare(strict_types=1);

namespace PandaLeague\JsonSchemaBuilder\Tests;

use PandaLeague\JsonSchemaBuilder\aArr;
use PandaLeague\JsonSchemaBuilder\aBool;
use PandaLeague\JsonSchemaBuilder\aNull;
use PandaLeague\JsonSchemaBuilder\aNum;
use PandaLeague\JsonSchemaBuilder\aObj;
use PandaLeague\JsonSchemaBuilder\aStr;
use PandaLeague\JsonSchemaBuilder\Factory;
use PHPUnit\Framework\TestCase;

final class FactoryTest extends TestCase
{
    public function testStrReturnsStringType(): void
    {
        $type = Factory::str();

        $this->assertInstanceOf(aStr::class, $type);
        $this->assertEquals(['type' => 'string'], $type->toArray());
    }

    public function testNumReturnsNumberType(): void
    {
        $type = Factory::num();

        $this->assertInstanceOf(aNum::class, $type);
        $this->assertEquals(['type' => 'number'], $type->toArray());
    }

    public function testBoolReturnsBooleanType(): void
    {
        $type = Factory::bool();

        $this->assertInstanceOf(aBool::class, $type);
        $this->assertEquals(['type' => 'boolean'], $type->toArray());
    }

    public function testArrReturnsArrayType(): void
    {
        $type = Factory::arr();

        $this->assertInstanceOf(aArr::class, $type);
        $this->assertEquals(['type' => 'array'], $type->toArray());
    }

    public function testObjReturnsObjectType(): void
    {
        $type = Factory::obj();

        $this->assertInstanceOf(aObj::class, $type);
        $this->assertEquals(['type' => 'object'], $type->toArray());
    }

    public function testNullReturnsNullTypeWithEmptySchema(): void
    {
        $type = Factory::null();

        $this->assertInstanceOf(aNull::class, $type);
        $this->assertSame([], $type->toArray());
    }
}
