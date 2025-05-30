<?php

namespace Tests\Unit\Domain\ValueObject;

use Core\Domain\ValueObject\Cnpj;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CnpjUnitTest extends TestCase
{
    /**
     * @dataProvider validCnpjProvider
     */
    public function testValidCnpj($expect, $cnpj)
    {
        $this->assertEquals($expect, Cnpj::isValidCnpj($cnpj));
    }

    protected function validCnpjProvider()
    {
        return [
            "invalidFormat" => [false, "12345678"],
            "validFormattedCnpj" => [true, "11.222.333/0001-81"],
            "wrongCheckDigit" => [false, "11.222.333/0001-82"],
            "cnpjValidOnlyNumbers" => [true, "17256512033715"],
            "invalidCnpjOnlyNumbers" => [false, "17256512033716"],
        ];
    }

    public function testConstructor()
    {
        $cnpj = new Cnpj("17256512033715");
        $this->assertNotNull($cnpj);
    }

    public function testExceptionInConstructor()
    {
        $this->expectException(InvalidArgumentException::class);
        new Cnpj("11.222.333/0001-82");
    }

    
    public function testGetOnlyNumbers()
    {
        $cnpj = new Cnpj("11.222.333/0001-81");
        $this->assertEquals("11222333000181", $cnpj->getOnlyNumbers());
        $cnpj = new Cnpj("11222333000181");
        $this->assertEquals("11222333000181", $cnpj->getOnlyNumbers());
    }

    protected function testGetFormatted()
    {
        $cnpj = new Cnpj("11222333000181");
        $this->assertEquals("11.222.333/0001-81", $cnpj->getOnlyNumbers());
        $cnpj = new Cnpj("11.222.333/0001-81");
        $this->assertEquals("11.222.333/0001-81", $cnpj->getOnlyNumbers());
    }

    public function testRandomValidCnpj()
    {
        $cnpj = Cnpj::random();
        $this->assertInstanceOf(Cnpj::class, $cnpj);
    }

    public function testToString()
    {
        $this->assertEquals("17.256.512/0337-15", (string) new Cnpj("17256512033715"));
        $this->assertEquals("11.222.333/0001-81", (string) new Cnpj("11.222.333/0001-81"));
    }
}
