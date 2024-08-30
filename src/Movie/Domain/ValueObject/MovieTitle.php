<?php

declare(strict_types=1);

namespace App\Movie\Domain\ValueObject;

use App\Shared\Utils\StringUtil;
use Webmozart\Assert\Assert;

final readonly class MovieTitle implements \Stringable
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value, 'Movie title cannot be empty.');
        Assert::maxLength($value, 255, 'Movie title cannot exceed 255 characters.');

        $this->value = $value;
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function wordCount(): int
    {
        return StringUtil::countWords($this->value);
    }

    #[\Override]
    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(MovieTitle $other): bool
    {
        return $this->value === $other->value;
    }

    public function startsWithLetter(string $letter): bool
    {
        return str_starts_with($this->value, $letter);
    }

    public function hasEvenLength(): bool
    {
        return 0 === mb_strlen($this->value) % 2;
    }
}
