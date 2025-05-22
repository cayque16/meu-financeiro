<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\AssetType;
use Core\Domain\Entity\BaseEntity;
use Core\Domain\Exception\EntityValidationException;

class AssetTypeUnitTest extends EntityTestCaseUnitTest
{
    protected function entity(): BaseEntity
    {
        return new AssetType("BTC");
    }

    /**
     * @dataProvider providerConstruct
     */
    public function testExceptionsInConstructor($name, $description)
    {
        $this->expectException(EntityValidationException::class);
        new AssetType(name: $name, description: $description);
    }

    protected function providerConstruct(): array
    {
        return [
            'Test with name incorrect' => [
                'name' => 't',
                'description'=> ''
            ]
        ];
    }

    public function testUpdate()
    {
        $nameOld = 'Test Name';
        $descriptionOld = 'Test Description';

        $type = new AssetType(name: $nameOld, description: $descriptionOld);
        $type->update('Name update', 'Description update');

        $this->assertNotEquals($type->name, $nameOld);
        $this->assertNotEquals($type->description, $descriptionOld);
    }

    public function testUpdateNotEditOtherFields()
    {
        $type = new AssetType(name: 'name', description: 'desc');
        
        $this->assertEquals('name', $type->name);
        $this->assertEquals('desc', $type->description);
        $type->update(name: 'new name');
        $this->assertEquals('new name', $type->name);
        $this->assertEquals('desc', $type->description);
        $type->update(description: 'new desc');
        $this->assertEquals('new name', $type->name);
        $this->assertEquals('new desc', $type->description);
    }

    /**
     * @dataProvider providerConstruct
     */
    public function testUpdateException($name, $description)
    {
        $type = new AssetType(name: 'Name valid', description: 'Description');
        $this->expectException(EntityValidationException::class);
        $type->update($name, $description);
    }
}
