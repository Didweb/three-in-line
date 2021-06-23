<?php

declare(strict_types=1);

namespace App\Domain\Model;


final class Board
{
    private bool $gameIsActive;
    private int $rows;
    private int $columns;
    private array $cells;
    private string $turn;
    private string $winner = "0";

    public function __construct(
        bool $gameIsActive = true,
        int $rows = 0,
        int $columns = 0,
        array $cells = [],
        string $turn = 'Human'
    ) {
        $this->gameIsActive = $gameIsActive;
        $this->rows = $rows;
        $this->columns = $columns;
        $this->cells = $cells;
        $this->turn = $turn;
    }

    public function theWinnerIs(string $winner): void
    {
        $this->winner = $winner;
    }

    public function winner(): string
    {
        return $this->winner;
    }

    public function rows(): int
    {
        return $this->rows;
    }


    public function turn(): string
    {
        return $this->turn;
    }

    public function cells(): array
    {
        return $this->cells;
    }

    public function changeTurn($player): void
    {
        $this->turn = $player;
    }

    public function boardDataJson(): string
    {
        $board['board'] = json_encode(
            [
                'statusGame' => $this->gameIsActive,
                'rows'       => $this->rows,
                'columns'    => $this->columns,
                'turn'       => $this->turn
            ]
        );
        return json_encode($board);
    }


    public function markCell(string $prefixPlayer, string $namePlayer, int $row, int $column): void
    {
        if ($this->cells[$row][$column]['content'] != 0) {
            throw new \Exception('This cell has already been marked. Not free');
        }
        $this->cells[$row][$column]['content'] = $prefixPlayer;
        $this->changeTurn($namePlayer);
    }

    public function updateRatingsCells($cells): void
    {
        $this->cells = $cells;
    }

    public function buildBoard(int $dimension): array
    {
        $this->rows = $dimension;
        $this->columns = $dimension;
        $cells = [];
        $loop = 0;
        for ($rowLoop = 0; $rowLoop <= $dimension; $rowLoop++) {
            for ($columnLoop = 0; $columnLoop <= $dimension; $columnLoop++) {
                $cells[$rowLoop][$columnLoop] = [
                    'content' => 0,
                    'rating' => $this->calculateRating($rowLoop, $columnLoop, $loop)
                ];
            }
            $loop++;
        }
        $this->cells = $cells;

        return $this->cells;
    }

    public function cleanValuesCells(): array
    {
        $cells = $this->cells;
        $loop = 0;
        for ($rowLoop = 0; $rowLoop <= $this->rows; $rowLoop++) {
            for ($columnLoop = 0; $columnLoop <= $this->rows; $columnLoop++) {
                $cells[$rowLoop][$columnLoop] = [
                    'content' => $cells[$rowLoop][$columnLoop]['content'],
                    'rating' => $this->calculateRating($rowLoop, $columnLoop, $loop)
                ];
            }
            $loop++;
        }
        $this->cells = $cells;
        return $this->cells;
    }

    private function calculateRating($rowLoop, $columnLoop, $loop): int
    {
        $rating = 2;
        $valueSum = 0;
        $realColumn = $this->columns;
        /** Calculate corners */
        if (($columnLoop == 0 || $columnLoop == $this->columns)
            && ($rowLoop == 0 || $rowLoop == $this->rows)) {
            $valueSum = 1;
        }

        /** Calcualte first diagonal*/
        if ($rowLoop == $columnLoop) {
            $valueSum = 1;
        }

        /** Calcualte second diagonal*/
        if ($columnLoop == ($realColumn - $loop)) {
            $valueSum = 1;
        }

        return $rating + $valueSum;
    }

    public function create(
        bool $gameIsActive,
        int $rows,
        int $columns,
        array $cells,
        string $turn
    ): Board {
        $this->gameIsActive = $gameIsActive;
        $this->rows = $rows;
        $this->columns = $columns;
        $this->cells = $cells;
        $this->turn = $turn;

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
                'turn' => $this->turn

            ]
        ];
    }
}