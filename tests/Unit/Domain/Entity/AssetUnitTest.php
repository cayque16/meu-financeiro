<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Asset;
use Core\Domain\Entity\AssetType;
use Core\Domain\Entity\BaseEntity;
use Core\Domain\Exception\EntityValidationException;
use Mockery;

class AssetUnitTest extends EntityTestCaseUnitTest
{
    protected function entity(): BaseEntity
    {
        $mockType = $this->mockType();
        return new Asset("TEST", $mockType);
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


    /**
     * @dataProvider providerUpdate
     */
    public function testUpdate($newCode, $newType, $newDescription)
    {
        $oldCode = 'TEST';
        $oldType = $this->mockType();
        $oldDescription = 'desc';
        $asset = new Asset(code: $oldCode, type: $oldType, description: $oldDescription);
        
        $asset->update($newCode, $newType, $newDescription);

        $this->assertEquals($newCode ?? $oldCode, $asset->code);
        $this->assertEquals($newType ?? $oldType, $asset->type);
        $this->assertEquals($newDescription ?? $oldDescription, $asset->description);
    }

    protected function providerUpdate()
    {
        $code = 'new code';
        $type = $this->mockType();
        $desc = 'new desc';
        return [
            'Test with all null' => [null, null, null],
            'Test with desc only' => [null, null, $desc],
            'Test with type only' => [null, $type, null],
            'Test with type and desc' => [null, $type, $desc],
            'Test with code only' => [$code, null, null],
            'Test with code and desc' => [$code, null, $desc],
            'Test with code and type' => [$code, $type, null],
            'Test with code, type and desc' => [$code, $type, $desc],
        ];
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
