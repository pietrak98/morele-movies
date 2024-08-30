<?php

declare(strict_types=1);

namespace App\Tests\Unit\Movie\Domain\ValueObject;

use App\Movie\Domain\ValueObject\MovieTitle;
use PHPUnit\Framework\TestCase;

final class MovieTitleTest extends TestCase
{
    public function testItCanBeCreatedWithValidTitle(): void
    {
        $title = new MovieTitle('Inception');
        $this->assertInstanceOf(MovieTitle::class, $title);
        $this->assertEquals('Inception', $title->toString());
    }

    public function testItThrowsExceptionForEmptyTitle(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Movie title cannot be empty.');

        new MovieTitle('');
    }

    public function testItThrowsExceptionForTooLongTitle(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Movie title cannot exceed 255 characters.');

        new MovieTitle(str_repeat('A', 256));
    }

    public function testItEqualsAnotherMovieTitleWithSameValue(): void
    {
        $title1 = new MovieTitle('Inception');
        $title2 = new MovieTitle('Inception');

        $this->assertTrue($title1->equals($title2));
    }

    public function testItDoesNotEqualAnotherMovieTitleWithDifferentValue(): void
    {
        $title1 = new MovieTitle('Inception');
        $title2 = new MovieTitle('The Matrix');

        $this->assertFalse($title1->equals($title2));
    }

    public function testStartsWithLetter(): void
    {
        $title = new MovieTitle('Wonder Woman');

        $this->assertTrue($title->startsWithLetter('W'));
        $this->assertFalse($title->startsWithLetter('A'));
    }

    public function testHasEvenLength(): void
    {
        $title = new MovieTitle('Wonder Woman');

        $this->assertTrue($title->hasEvenLength());

        $title = new MovieTitle('Batman');
        $this->assertTrue($title->hasEvenLength());
    }
}
