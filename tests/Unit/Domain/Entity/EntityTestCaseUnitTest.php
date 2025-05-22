<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\BaseEntity;
use Core\Domain\ValueObject\Date;
use PHPUnit\Framework\TestCase;

abstract class EntityTestCaseUnitTest extends TestCase
{
    abstract protected function entity(): BaseEntity;

    public function testDefaultFields()
    {
        $entity = $this->entity();
        $this->assertNotNull($entity->id());
        $this->assertNotNull($entity->createdAt);
        $this->assertInstanceOf(Date::class, $entity->createdAt);
        $this->assertNull($entity->updatedAt());
        $this->assertNull($entity->deletedAt());
        $this->assertTrue($entity->isActive());
    }
}
