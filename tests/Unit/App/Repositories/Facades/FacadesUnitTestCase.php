<?php

namespace Tests\Unit\App\Repositories\Facades;

use Tests\TestCase;

abstract class FacadesUnitTestCase extends TestCase
{
    abstract protected function getRepositoryClass(): string;

    abstract protected function getFacadeCreateRepository();

    public function testCreateRepository()
    {
        $this->assertInstanceOf(
            $this->getRepositoryClass(),
            $this->getFacadeCreateRepository()
        );
    }
}
