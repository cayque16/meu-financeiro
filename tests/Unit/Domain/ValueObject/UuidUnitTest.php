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
}
