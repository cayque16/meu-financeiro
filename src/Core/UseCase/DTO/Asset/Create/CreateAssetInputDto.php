<?php

namespace Core\UseCase\DTO\Asset\Create;

class CreateAssetInputDto
{
    public function __construct(
        public string $code,
        public string $idType,
        public string $description = '',
    ) { }
}
