<?php

declare(strict_types=1);

namespace TTN\Tea\Tests\Unit\Domain\Model;

use TTN\Tea\Domain\Model\Tea;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * @covers \TTN\Tea\Domain\Model\Tea
 */
final class TeaTest extends UnitTestCase
{
    private Tea $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new Tea();
    }

    /**
     * @test
     */
    public function isAbstractEntity(): void
    {
        self::assertInstanceOf(AbstractEntity::class, $this->subject);
    }

    /**
     * @test
     */
    public function getTitleInitiallyReturnsEmptyString(): void
    {
        self::assertSame('', $this->subject->getTitle());
    }

    /**
     * @test
     */
    public function setTitleSetsTitle(): void
    {
        $value = 'Earl Grey';
        $this->subject->setTitle($value);

        self::assertSame($value, $this->subject->getTitle());
    }

    /**
     * @test
     */
    public function getDescriptionInitiallyReturnsEmptyString(): void
    {
        self::assertSame('', $this->subject->getDescription());
    }

    /**
     * @test
     */
    public function setDescriptionSetsDescription(): void
    {
        $value = 'Very refreshing and amoratic.';
        $this->subject->setDescription($value);

        self::assertSame($value, $this->subject->getDescription());
    }

    /**
     * @test
     */
    public function getRatingInitiallyReturnsZero(): void
    {
        self::assertSame(0, $this->subject->getRating());
    }

    /**
     * @return \int[][]
     */
    public static function validRatingDataProvider(): array
    {
        return [
            [0],
            [1],
            [2],
            [3],
            [4],
            [5],
        ];
    }

    /**
     * @test
     * @dataProvider validRatingDataProvider
     */
    public function setRatingSetsRating($rating): void
    {
        $this->subject->setRating($rating);

        self::assertSame($rating, $this->subject->getRating());
    }

    /**
     * @test
     */
    public function setRatingWithRatingLessZeroThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Rating must not be less than 0.');
        $this->expectExceptionCode(1729086648);

        $this->subject->setRating(-1);
    }

    /**
     * @test
     */
    public function setRatingWithRatingGreaterFiveThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Rating must not be greater than 5.');
        $this->expectExceptionCode(1729086972);

        $this->subject->setRating(6);
    }

    /**
     * @test
     */
    public function getImageInitiallyReturnsNull(): void
    {
        self::assertNull($this->subject->getImage());
    }

    /**
     * @test
     */
    public function setImageSetsImage(): void
    {
        $model = new FileReference();
        $this->subject->setImage($model);

        self::assertSame($model, $this->subject->getImage());
    }

    /**
     * @test
     */
    public function getOwnerUidInitiallyReturnsZero(): void
    {
        self::assertSame(0, $this->subject->getOwnerUid());
    }

    /**
     * @test
     */
    public function setOwnerUidSetsOwnerUid(): void
    {
        $value = 123456;
        $this->subject->setOwnerUid($value);

        self::assertSame($value, $this->subject->getOwnerUid());
    }
}
