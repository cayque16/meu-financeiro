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
}
