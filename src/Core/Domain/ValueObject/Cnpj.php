<?php

namespace Core\Domain\ValueObject;

use InvalidArgumentException;

class Cnpj
{
    public function __construct(protected string $cnpj)
    {
        $this->ensureIsValid($cnpj);
    }

    private function ensureIsValid(string $cnpj): void
    {
        if (!self::isValidCnpj($cnpj)) {
            throw new InvalidArgumentException(sprintf(
                "%s is not a valid CNPJ, it must have only numbers or be in the format: %s",
                $cnpj,
                "XX.XXX.XXX/XXXX-XX"
            ));
        }
    }

    public static function isValidCnpj(string $cnpj): bool
    {
        $cnpj = self::sanitizeCnpj($cnpj);
        if (strlen($cnpj) < 14) {
            return false;
        }

        return substr($cnpj, 12, 14) == self::generateCheckDigit(substr($cnpj, 0, 12));
    }

    public function getOnlyNumbers(): string
    {
        return self::sanitizeCnpj($this->cnpj);
    }

    public function getFormatted(): string
    {
        return (string) $this->cnpj;
    }

    public static function random(): self
    {
        $cnpjWithoutDigit = '';
        for ($i = 0; $i < 12; $i++) {
            $cnpjWithoutDigit .= rand(0,9);
        }

        return new self($cnpjWithoutDigit.self::generateCheckDigit($cnpjWithoutDigit));
    }

    public function __toString(): string
    {
        if ($this->isFormatted()) {
            return $this->cnpj;
        }

        return substr($this->cnpj, 0, 2)
            .".".
            substr($this->cnpj, 2, 3)
            .".".
            substr($this->cnpj, 5, 3)
            ."/".
            substr($this->cnpj, 8, 4)
            ."-".
            substr($this->cnpj, 12, 2);
    }

    private static function sanitizeCnpj(string $cnpj): string
    {
        return str_replace('/','',str_replace('.','',str_replace('-','', $cnpj)));
    }

    private function isFormatted(): bool
    {
        return strlen($this->cnpj) == 18;
    }

    private static function getSum(string $cnpj, int $multiplier): int
    {
        $sum = 0;
        foreach (str_split($cnpj) as $digit) {
            $sum += $digit * $multiplier;
            $multiplier--;
            if ($multiplier == 1) {
                $multiplier = 9;
            }
        }
        return $sum;
    }

    private static function calculateDigit(int $rest): int
    {
        return $rest < 2 ? 0 : 11 - $rest;
    }

    private static function generateCheckDigit(string $cnpjWithoutDigit): string
    {
        $rest = self::getSum($cnpjWithoutDigit, 5) % 11;

        $firstCheckDigit = self::calculateDigit($rest);

        $cnpjWithoutDigit .= $firstCheckDigit;

        $rest = self::getSum($cnpjWithoutDigit, 6) % 11;

        $secondCheckDigit = self::calculateDigit($rest);

        return $firstCheckDigit . $secondCheckDigit;
    }
}
