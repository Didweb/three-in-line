<?php

declare(strict_types=1);

namespace App\Domain\Model;


use App\Application\Command\BoardCommand;
use App\Domain\Repository\BoardRepository;

final class Board
{
    private bool $gameIsActive;
    private int $rows;
    private int $columns;
    private array $cells;
    private BoardCommand $jsonBoard;

    public function __construct(BoardRepository $repository, BoardCommand $boardCommand)
    {

        $this->jsonBoard = $repository->getBoardData($boardCommand);

        $this->create(
            $this->jsonBoard->gameIsActive(),
            $this->jsonBoard->rows(),
            $this->jsonBoard->columns(),
            $this->jsonBoard->cells(),
        );
    }


    public function boardDataJson(): string
    {
        $board['board'] = json_encode(
            [
                'statusGame' => $this->gameIsActive,
                'rows' => $this->rows,
                'columns' => $this->columns
            ]
        );
        return json_encode($board);
    }

    public function create(
        bool $gameIsActive,
        int $rows,
        int $columns,
        array $cells
    ): Board
    {
        $this->gameIsActive = $gameIsActive;
        $this->rows = $rows;
        $this->columns = $columns;
        $this->cells = $cells;

        return $this;
    }


}