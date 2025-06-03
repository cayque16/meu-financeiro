<?php

namespace App\Repositories\Facades;

use Core\Domain\Repository\BaseRepositoryInterface;

interface RepositoryFacadeInterface
{
    public static function createRepository(): BaseRepositoryInterface;
}
