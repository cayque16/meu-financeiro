<?php

namespace Tests\Unit\Domain\ValueObject;

use Core\Domain\ValueObject\Uuid;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class UuidUnitTest extends TestCase
{
    public function testConstruct()
    {
        $uuid = new Uuid('6e864e97-9b7d-4532-a540-e2636460512f');
        $this->assertSame('6e864e97-9b7d-4532-a540-e2636460512f', $uuid->__toString());
    }

    public function testRandom()
    {
        $uuid = Uuid::random();
        $this->assertNotNull($uuid);
    }

    public function testInvalidUuid()
    {
        $this->expectException(InvalidArgumentException::class);
        new Uuid('invalid-uuid');
    }

    public function testIsUuidValid()
    {
        $this->assertTrue(Uuid::isUuidValid("f8a73613-727a-4723-8612-fc438a4ad9be"));
        $this->assertFalse(Uuid::isUuidValid("invalid-uuid"));
    }

    public function testShortFormat()
    {
        $uuid = new Uuid('efddc805-fdf8-4350-b3cb-11475f15ae76');
        $this->assertEquals('efddc805', $uuid->short($uuid));
    }

    public function testShortFormatInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->assertEquals('efddc805', Uuid::short('uuid'));
    }
}
