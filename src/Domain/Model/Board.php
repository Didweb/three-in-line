<?php

declare(strict_types=1);

namespace App\Domain\Model;

final class Board
{
    private bool $gameIsActive;
    private int $rows;
    private int $columns;
    private array $cells;

    public function __construct(bool $gameIsActive, int $rows, int $columns, array $cells)
    {
        $this->gameIsActive = $gameIsActive;
        $this->rows = $rows;
        $this->columns = $columns;
        $this->cells = $cells;
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