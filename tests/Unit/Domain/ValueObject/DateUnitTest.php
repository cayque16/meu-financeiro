<?php

namespace Tests\Unit\Domain\ValueObject;

use Core\Domain\ValueObject\Date;
use DateTime;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DateUnitTest extends TestCase
{
    public function testExceptionConstruct()
    {
        $this->expectException(InvalidArgumentException::class);
        new Date("test");
    }

    public function testFromDateTime()
    {
        $date = Date::fromDateTime(new DateTime());
        $this->assertInstanceOf(Date::class, $date);
    }

    public function testDateBr()
    {
        $date = new Date("15-12-2025 15:15:58");
        $this->assertEquals("15/12/2025", $date->toDateBr());
        $this->assertEquals("15/12/2025 15:15:58", $date->toDateBr(true));
    }

    public function testDateTime()
    {
        $date = new Date("2024-01-01 15:15:58");
        $this->assertInstanceOf(Date::class, $date);
    }

    public function testToString()
    {
        $date = new Date("15-04-1994 19:30:00");
        $this->assertEquals("1994-04-15 19:30:00", (string) $date);
    }

    public function testGetYear()
    {
        $date = new Date("15-04-1994");
        $this->assertEquals(1994, $date->getYear());

        $date = new Date("2035-04-15");
        $this->assertEquals(2035, $date->getYear());

        $date = Date::fromDateTime(new DateTime("15-04-1974"));
        $this->assertEquals(1974, $date->getYear());
    }
}
