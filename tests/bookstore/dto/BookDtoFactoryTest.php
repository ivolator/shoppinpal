<?php

namespace bookstore\dto;

use bookstore\exceptions\Exception400;
use PHPUnit\Framework\TestCase;

class BookDtoFactoryTest extends TestCase
{

    /**
     * @dataProvider jsonSuccessDataProvider
     * @throws Exception400
     */
    public function testCreate($book)
    {
        $dto = (new BookDtoFactory())->create($book);
        $this->assertEquals($book['id'], $dto->getId());
        $this->assertEquals($book['title'], $dto->getTitle());
        $this->assertEquals($book['releaseDate'], $dto->getReleaseDate());
        $this->assertEquals($book['isbn'], $dto->getIsbn());
        $this->assertEquals($book['author'], $dto->getAuthor());
    }

    public function jsonSuccessDataProvider()
    {
        return [
            [['id' => 1, 'title' => 'T1', 'releaseDate' => '2001-01-01', 'author' => 'A1', 'isbn' => 'Isbn1234']],
        ];
    }

    /**
     * Test error with corresponding message from data provider
     * @dataProvider jsonFailureDataProvider
     */
    public function testCreateFailForEach($book, $expectedExceptionMessage)
    {
        try {
            (new BookDtoFactory())->create($book);
        } catch (Exception400 $e) {
            $this->assertEquals($expectedExceptionMessage, $e->getMessage());
        }

    }


    /**
     * @return \array[][]
     */
    public function jsonFailureDataProvider()
    {
        return [
            [['title' => 'T1', 'releaseDate' => '2001-01-01', 'author' => 'A1', 'isbn' => 'Isbn1234'], 'Book ID can\'t be empty or 0'],//missing id
            [['id' => 1, 'releaseDate' => '2001-01-01', 'author' => 'A1', 'isbn' => 'Isbn1234'], 'Missing book Title name'],//missing title
            [['id' => 1, 'title' => 'T1', 'releaseDate' => '20-01', 'author' => 'A1', 'isbn' => 'Isbn1234'], 'Invalid date format. Use MySQL format'],//wrong date
            [['id' => 1, 'title' => 'T1', 'releaseDate' => '2001-01-01', 'isbn' => 'Isbn1234'], 'Missing book Author name'],//no author
            [['id' => 1, 'title' => 'T1', 'releaseDate' => '2001-01-01', 'author' => 'A1'], 'Missing ISBN value'],//no isbn
        ];
    }
}
