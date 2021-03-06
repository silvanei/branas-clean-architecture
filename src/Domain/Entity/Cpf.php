<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Domain\Entity;

use Ds\Set;
use InvalidArgumentException;

final class Cpf
{
    public readonly string $value;

    private const CPF_VALID_LENGTH = 11;
    private const FACTOR_FIRST_VIRIFIER_DIGIT = 10;
    private const FACTOR_SECOND_VIRIFIER_DIGIT = 11;


    public function __construct(string $value)
    {
        $cleanedValue = $this->clean($value);
        if (! $this->isValidLength($cleanedValue)) {
            throw new InvalidArgumentException('Invalid CPF length');
        }
        if ($this->areAllDigitsEqual($cleanedValue)) {
            throw new InvalidArgumentException('Invalid CPF');
        }
        $firstVerifierDigit = $this->calculateDigit($cleanedValue, self::FACTOR_FIRST_VIRIFIER_DIGIT);
        $secondVerifierDigit = $this->calculateDigit($cleanedValue, self::FACTOR_SECOND_VIRIFIER_DIGIT);
        $calculatedVerifiedDigit = $firstVerifierDigit . $secondVerifierDigit;
        $verifierDigit = $this->extractVerifierDigit($cleanedValue);
        if ($verifierDigit !== $calculatedVerifiedDigit) {
            throw new InvalidArgumentException('Invalid CPF verifier digit');
        }
        $this->value = $cleanedValue;
    }

    private function clean(string $cpf): string
    {
        $cpf = preg_replace('/\D/', '', $cpf);
        return is_string($cpf) ? $cpf : '';
    }

    private function isValidLength(string $cpf): bool
    {
        return strlen($cpf) === self::CPF_VALID_LENGTH;
    }

    private function areAllDigitsEqual(string $cpf): bool
    {
        $arrayCpf = str_split($cpf);
        $setCpf = new Set($arrayCpf);
        return $setCpf->count() === 1;
    }

    private function calculateDigit(string $cpf, int $factor): int
    {
        $total = 0;
        $cpf = str_split($cpf);
        foreach ($cpf as $digit) {
            if ($factor > 1) {
                $total += (int)$digit * $factor--;
            }
        }
        $rest = $total % self::CPF_VALID_LENGTH;
        return ($rest < 2) ? 0 : (self::CPF_VALID_LENGTH - $rest);
    }

    private function extractVerifierDigit(string $cpf): string
    {
        return substr($cpf, strlen($cpf) - 2, strlen($cpf));
    }
}
