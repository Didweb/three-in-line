<?php

declare(strict_types=1);

namespace App\Test\Domain;


use App\Domain\Model\Board;
use App\Domain\Repository\BoardRepository;

use App\Tests\Double\Persistence\Memory\InFileBoardRepositoryStub;
use PHPUnit\Framework\TestCase;

final class BoardTest extends TestCase
{

    private BoardRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = InFileBoardRepositoryStub::repository();

        if (file_exists($this->repository::PATH_SOURCES)) {
            unlink($this->repository::PATH_SOURCES);
        }

    }


    public function test_should_create_board_3_columns(): void
    {
        $board = $this->repository->getBoardData();
        $board->buildBoard(2);
        $this->repository->save($board);
        $countColumns = count($board->cells());

        $this->assertEquals(3, $countColumns);
    }

    public function test_should_create_board_7_columns(): void
    {
        $board = $this->repository->getBoardData();
        $board->buildBoard(6);
        $this->repository->save($board);
        $countColumns = count($board->cells());

        $this->assertEquals(7, $countColumns);
    }

    public function tearDown(): void
    {
        if (file_exists($this->repository::PATH_SOURCES)) {
            unlink($this->repository::PATH_SOURCES);
        }
    }
}