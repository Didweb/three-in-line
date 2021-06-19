<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Model\Board;

final class Intelligence
{
    private array $cellsCheck;
    private int $winIn;

    public function bestOption(Board $board): ?array
    {
        $board->cleanValuesCells();
        $this->winIn = count($board->cells());
        $cellsOptions = $this->currentRatings($board->cells());
        $board->updateRatingsCells($this->cellsCheck);
        $randOption = rand(0, count($cellsOptions) - 1);

        if (!isset($cellsOptions[$randOption])) {
            return null;
        }
        return [
            'row' => $cellsOptions[$randOption]['row'],
            'column' => $cellsOptions[$randOption]['column']
        ];
    }


    private function currentRatings($cells): array
    {
        $highestScore = 0;
        $loop = 0;
        $totalColumns = count($cells) - 1;

        foreach ($cells as $row => $column) {
            foreach ($column as $keyColumn => $value) {
                $currentRating = $value['rating'];

                if ($this->rowHasEnemies($cells[$row])) {
                    $currentRating++;
                }

                if ($this->columnHasEnemies($keyColumn, $cells)) {
                    $currentRating++;
                }
//
//                if ($this->diagonalsHasEnemies($row, $keyColumn, $loop, $totalColumns, $cells)) {
//                    $currentRating++;
//                }

dump($currentRating);

                $currentRating = $currentRating + $this->blockEnemiesRows($cells[$row]);

                $currentRating = $currentRating + $this->blockEnemiesColumns($keyColumn, $cells);
//                $currentRating = $currentRating + $this->blockEnemiesDiagonals(
//                        $row,
//                        $keyColumn,
//                        $loop,
//                        $totalColumns,
//                        $cells
//                    );


                $cells[$row][$keyColumn]['rating'] = $currentRating;

                if ($currentRating > $highestScore && $value['content'] === 0) {
                    $highestScore = $currentRating;
                }
            }
            $loop++;
        }

        $this->cellsCheck = $cells;
        $candidates = [];
        foreach ($cells as $row => $column) {
            foreach ($column as $keyColumn => $value) {
                if ($cells[$row][$keyColumn]['rating'] == $highestScore
                    && $cells[$row][$keyColumn]['content'] === 0) {
                    $candidates[] = ['row' => $row, 'column' => $keyColumn];
                }
            }
        }
        return $candidates;
    }

    private function rowHasEnemies($row): bool
    {
        $result = false;
        foreach ($row as $columns => $values) {
            if ($values['content'] === "H") {
                return true;
            }
        }
        return false;
    }

    private function columnHasEnemies($column, $cells): bool
    {
        $result = false;
        for ($row = 0; $row < count($cells); $row++) {
            if ($cells[$row][$column]['content'] === "H") {
                $result = true;
            }
        }
        return $result;
    }

    private function diagonalsHasEnemies($rowLoop, $columnLoop, $loop, $totalColumns, $cells): bool
    {
        $result = false;
        /** Calcualte first diagonal*/
        foreach ($cells as $rows => $columns) {
            foreach ($columns as $keyColumn => $values) {
                for ($row = 0; $row < count($cells); $row++) {
                    if ($rowLoop == $columnLoop && $values['content'] == "H") {
                        $result = true;
                    }
                }
            }
        }


        /** Calcualte second diagonal*/
        foreach ($cells as $rows => $columns) {
            foreach ($columns as $keyColumn => $values) {
                for ($row = 0; $row < count($cells); $row++) {
                    if ($columnLoop == ($totalColumns - $loop) && $values['content'] == "H") {
                        $result = true;
                    }
                }
            }
        }


        return $result;
    }

    private function blockEnemiesRows($row): int
    {
        $enemiesInRow = 0;
        foreach ($row as $columns => $values) {
            if ($values['content'] === "H") {
                $enemiesInRow++;
            }
        }

        return $enemiesInRow;
    }

    private function blockEnemiesColumns($column, $cells): int
    {
        $enemiesInColumns = 0;
        for ($row = 0; $row < count($cells); $row++) {
            if ($cells[$row][$column]['content'] === "H") {
                $enemiesInColumns++;
            }
        }

        return $enemiesInColumns;
    }

    private function blockEnemiesDiagonals($rowLoop, $columnLoop, $loop, $totalColumns, $cells): int
    {
        $enemiesInDiagonals = 0;

        /** Calcualte first diagonal*/
        foreach ($cells as $rows => $columns) {
            foreach ($columns as $keyColumn => $values) {
                if ($rows == $keyColumn
                    && $values['content'] == "H") {
                    $enemiesInDiagonals++;
                }
            }
        }

        /** Calcualte second diagonal*/
        foreach ($cells as $rows => $columns) {
            foreach ($columns as $keyColumn => $values) {
                    if ($keyColumn == ($totalColumns - $loop) && $values['content'] == "H") {
                        $enemiesInDiagonals++;
                    }

            }
        }


        dump($enemiesInDiagonals . ' in --> ' . $rowLoop . '/' . $columnLoop );
        return $this->extraAlert($enemiesInDiagonals);
    }


    private function extraAlert($enemies): int
    {
        if ($enemies >= $this->winIn - 3) {
            $enemies = $enemies + 5;
           // dump('EXTRA');
        }

        return $enemies;
    }
}