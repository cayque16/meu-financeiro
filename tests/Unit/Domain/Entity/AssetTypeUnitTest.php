<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\AssetType;
use Core\Domain\Exception\EntityValidationException;
use PHPUnit\Framework\TestCase;

class AssetTypeUnitTest extends TestCase
{
    public function testConstruct()
    {
        $type = new AssetType("Ação");
        
        $this->assertNotNull($type->id());
        $this->assertNotNull($type->createdAt());
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
