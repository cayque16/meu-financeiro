<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Asset;
use Core\Domain\Entity\AssetType;
use Core\Domain\Exception\EntityValidationException;
use Mockery;
use PHPUnit\Framework\TestCase;

class AssetUnitTest extends TestCase
{
    public function testConstruct()
    {
        $mockType = $this->mockType();
        $asset = new Asset("TEST", $mockType);

        $this->assertNotNull($asset->id());
        $this->assertNotNull($asset->createdAt());
    }

    /**
     * @dataProvider providerConstruct
     */
    public function testExceptionsInConstructor($code, $type, $description)
    {
        $this->expectException(EntityValidationException::class);
        new Asset(code: $code, type: $type, description: $description);
    }

    protected function providerConstruct(): array
    {
        return [
            'Test with name incorrect' => [
                'code' => 't',
                'type' => $this->mockType(),
                'description'=> '',
            ]
        ];
    }

    public function testUpdate()
    {
        $type = $this->mockType();
        $asset = new Asset(code: 'TEST', type: $type, description: 'desc');
        
        $this->assertEquals('TEST', $asset->code);
        
        $asset->update('new code');

        $this->assertEquals('new code', $asset->code);
        $this->assertEquals($type, $asset->type);
        $this->assertEquals('desc', $asset->description);
    }

    /**
     * @dataProvider providerConstruct
     */
    public function testUpdateException($code, $type, $description)
    {
        $asset = new Asset(code: 'code', type: $type, description: 'desc');
        $this->expectException(EntityValidationException::class);
        $asset->update($code, $type, $description);
    }

    private function mockType()
    {
        $mockType = Mockery::mock(AssetType::class, ['stock']);

        return $mockType;
    }
}
