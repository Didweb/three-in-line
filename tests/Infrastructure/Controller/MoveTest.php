<?php

declare(strict_types=1);

namespace App\Test\Domain;


use App\Application\Command\HumanCommandHandler;
use App\Application\Command\RobotCommandHandler;
use App\Domain\Model\Board;
use App\Domain\Repository\BoardRepository;
use App\Tests\Double\Persistence\Memory\InFileBoardRepositoryStub;
use PHPUnit\Framework\TestCase;

final class MoveTest extends TestCase
{
    private BoardRepository $repository;
    private Board $board;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = InFileBoardRepositoryStub::repository();

        if (file_exists($this->repository::PATH_SOURCES)) {
            unlink($this->repository::PATH_SOURCES);
        }
        $this->board = $this->repository->getBoardData();
    }

    public function test_should_move_human_And_robot(): void
    {
        $this->board->buildBoard(2);
        $humanPlayer =  new HumanCommandHandler();
        $rowSelect = 0;
        $columnSelect = 2;
        $humanPlayer->move($this->board, $rowSelect, $columnSelect);

        $contentHuman = $this->board->cells()[$rowSelect][$columnSelect]['content'];
        $contentVoid = $this->board->cells()[0][1]['content'];

        $this->assertEquals("H",$contentHuman);
        $this->assertEquals("0",$contentVoid);

        $humanPlayer->move($this->board, 1, 1);

        $robotPlayer =  new RobotCommandHandler();
        $robotPlayer->move($this->board);

        $contentRobot = $this->board->cells()[2][0]['content'];

        $this->assertEquals("R",$contentRobot);

    }

    public function tearDown(): void
    {
        if (file_exists($this->repository::PATH_SOURCES)) {
            unlink($this->repository::PATH_SOURCES);
        }
    }
}