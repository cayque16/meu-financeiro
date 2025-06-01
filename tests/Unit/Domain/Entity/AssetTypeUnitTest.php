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

    /**
     * @dataProvider providerUpdate
     */
    public function testUpdate($newName, $newDesc)
    {
        $oldName = 'Test Name';
        $oldDesc = 'Test Description';

        $type = new AssetType(name: $oldName, description: $oldDesc);
        $type->update($newName, $newDesc);

        $this->assertEquals($newName ?? $oldName, $type->name);
        $this->assertEquals($newDesc ?? $oldDesc, $type->description);
    }

    protected function providerUpdate()
    {
        $name = 'new name';
        $desc = 'new desc';
        return [
            'Test with all null' => [null, null],
            'Test with desc only' => [null, $desc],
            'Test with name only' => [$name, null],
            'Test with name and desc' => [$name, $desc],
        ];
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
