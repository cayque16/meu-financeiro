<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\BaseEntity;
use Core\Domain\Entity\Brokerage;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\ValueObject\Cnpj;

class BrokerageUnitTest extends EntityTestCaseUnitTest
{
    protected function entity(): BaseEntity
    {
        return new Brokerage('Test', 'http://gejivu.np/nuivof', Cnpj::random());
    }

    /**
     * @dataProvider providerConstruct
     */
    public function testExceptionsInConstructor($name, $webPage, $cnpj)
    {
        $this->expectException(EntityValidationException::class);
        new Brokerage(name: $name, webPage: $webPage, cnpj: $cnpj);
    }

    protected function providerConstruct(): array
    {
        return [
            'Test with name incorrect' => [
                'name' => 'te',
                'webPage' => 'http://ufowo.ma/lejicas',
                'cnpj' => Cnpj::random(),
            ],
            'Test with url incorrect' => [
                'name' => 'name test',
                'webPage' => 'test',
                'cnpj' => Cnpj::random(),
            ],
        ];
    }

    public function testUpdate()
    {
        $cnpj = Cnpj::random();
        $brokerage = new Brokerage('Test', 'http://fapewsev.me/ebav', $cnpj);

        $this->assertEquals('Test', $brokerage->name);

        $brokerage->update('new name');
        $this->assertEquals('new name', $brokerage->name);
        $this->assertEquals('http://fapewsev.me/ebav', $brokerage->webPage);
        $this->assertEquals($cnpj, $brokerage->cnpj);
    }

    /**
     * @dataProvider providerConstruct
     */
    public function testUpdateException($name, $webPage, $cnpj)
    {
        $brokerage = new Brokerage('name', 'http://evulisku.ky/vuhi', Cnpj::random());
        $this->expectException(EntityValidationException::class);
        $brokerage->update($name, $webPage, $cnpj);
    }
}
