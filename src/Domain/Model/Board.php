<?php

declare(strict_types=1);

namespace App\Domain\Model;

final class Board
{
    private bool $gameIsActive;
    private int $rows;
    private int $columns;
    private array $cells;

    public function __construct(bool $gameIsActive = true, int $rows = 0, int $columns = 0, array $cells = [])
    {
        $this->gameIsActive = $gameIsActive;
        $this->rows = $rows;
        $this->columns = $columns;
        $this->cells = $cells;
    }

    public function cells(): array
    {
        return $this->cells;
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

    public function buildBoard(int $rows, int $columns): array
    {
        $this->rows = $rows;
        $this->columns = $columns;
        $cells = [];
        for ($r = 0; $r <= $rows; $r++) {
            for ($c = 0; $c <= $columns; $c++) {
                $cells[$r][$c] = 0;
            }
        }
        $this->cells = $cells;

        return $this->cells;
    }

    public function create(
        bool $gameIsActive,
        int $rows,
        int $columns,
        array $cells
    ): Board {
        $this->gameIsActive = $gameIsActive;
        $this->rows = $rows;
        $this->columns = $columns;
        $this->cells = $cells;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'board' => [
                'gameIsActive' => $this->gameIsActive,
                'rows' => $this->rows,
                'columns' => $this->columns,
                'cells' => $this->cells,

            ]
        ];
    }
}