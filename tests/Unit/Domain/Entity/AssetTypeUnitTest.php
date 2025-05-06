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
        new AssetType($name, $description);
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
}
