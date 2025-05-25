<?php

namespace Core\Domain\ValueObject;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid
{
    public function __construct(
        protected string $value
    ) {
        $this->ensureIsValid($value);
    }

    public static function random(): self
    {
        return new self(RamseyUuid::uuid4()->toString());
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function ensureIsValid(string $id)
    {
        if (!RamseyUuid::isValid($id)) {
            throw new InvalidArgumentException(sprintf("<%s> does not allow the value <%s>.", static::class, $id));
        }
    }

    public static function isUuidValid(string $uuid): bool
    {
        return RamseyUuid::isValid($uuid);
    }

    public static function short($uuid): string
    {
        if (!RamseyUuid::isValid($uuid)) {
            throw new InvalidArgumentException("$uuid is not a valid uuid!");
        }
        return explode('-', $uuid)[0];
    }
}
