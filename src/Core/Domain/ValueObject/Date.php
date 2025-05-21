<?php

namespace Core\Domain\ValueObject;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use InvalidArgumentException;

final class Date
{
    private DateTimeImmutable $date;

    public function __construct(string $date = "now")
    {
        try {
            $this->date = new DateTimeImmutable($date);
        } catch (Exception $e) {
            throw new InvalidArgumentException("Invalid date: {$date}");
        }
    }

    public static function fromDateTime(DateTimeInterface $dateTime): self
    {
        return new self($dateTime->format('Y-m-d'));
    }

    public function toDateTime(): DateTime
    {
        return DateTime::createFromImmutable($this->date);
    }

    public function toDateBr($time = false): string
    {
        return $this->date->format($time ? 'd/m/Y H:i:s' : 'd/m/Y');
    }

    public function __toString(): string
    {
        return $this->date->format("Y-m-d H:i:s");
    }
}
