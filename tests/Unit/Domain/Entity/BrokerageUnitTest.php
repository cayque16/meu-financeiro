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

    /**
     * @dataProvider providerConstruct
     */
    public function testUpdateException($name, $webPage, $cnpj)
    {
        $brokerage = new Brokerage('name', 'http://evulisku.ky/vuhi', Cnpj::random());
        $this->expectException(EntityValidationException::class);
        $brokerage->update($name, $webPage, $cnpj);
    }

    /**
     * @dataProvider providerUpdate
     */
    public function testUpdate($newName, $newWebPage, $newCnpj)
    {
        $oldName = 'Test';
        $oldWebPage = 'http://fapewsev.me/ebav';
        $oldCnpj = Cnpj::random();
        $brokerage = new Brokerage($oldName, $oldWebPage, $oldCnpj);

        $brokerage->update($newName, $newWebPage, $newCnpj);
        $this->assertEquals($newName ?? $oldName, $brokerage->name);
        $this->assertEquals($newWebPage ?? $oldWebPage, $brokerage->webPage);
        $this->assertEquals($newCnpj ?? $oldCnpj, $brokerage->cnpj);
    }

    protected function providerUpdate()
    {
        $name = 'new name';
        $webPage = 'http://ul.cz/liknokub';
        $cnpj = Cnpj::random();
        return [
            'Test with all null' => [null, null, null],
            'Test with CNPJ only' => [null, null, $cnpj],
            'Test with web page only' => [null, $webPage, null],
            'Test with web page and CNPJ' => [null, $webPage, $cnpj],
            'Test with name only' => [$name, null, null],
            'Test with name and CNPJ' => [$name, null, $cnpj],
            'Test with name and web page' => [$name, $webPage, null],
            'Test with name, web page, and CNPJ' => [$name, $webPage, $cnpj],
    ];
    }
}
