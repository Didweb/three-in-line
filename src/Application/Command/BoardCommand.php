<?php

declare(strict_types=1);

namespace App\Application\Command;


final class BoardCommand
{
    private bool $gameIsActive = true;
    private int $rows = 0;
    private int $columns = 0;
    private array $cells = [];

    public function create(bool $gameIsActive, int $rows, int $columns, array $cells)
    {
        $this->gameIsActive = $gameIsActive;
        $this->rows = $rows;
        $this->columns = $columns;
        $this->cells = $cells;
    }

    public function gameIsActive(): bool
    {
        return $this->gameIsActive;
    }

    public function rows(): int
    {
        return $this->rows;
    }

    public function columns(): int
    {
        return $this->columns;
    }

    public function cells(): array
    {
        return $this->cells;
    }

    public function toArray(): array
    {
        return [
            'board' => [
                'statusGame' => $this->gameIsActive,
                'rows' => $this->rows,
                'columns' => $this->columns,
                'cells' => $this->cells,

            ]
        ];
    }
}