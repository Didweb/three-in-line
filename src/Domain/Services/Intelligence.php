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
        $loop = 0;
        $highestScore = 0;
        $totalColumns = count($cells) - 1;

        $watcher = new Watcher('H','R', $totalColumns);

        foreach ($cells as $keyRow => $column) {
            foreach ($column as $keyColumn => $value) {
                $currentRating = $cells[$keyRow][$keyColumn]['rating'];
                $watcher->data($keyRow, $keyColumn, $cells);

                $currentRating = $currentRating + $watcher->watchDiagonalFirst();


                $cells[$keyRow][$keyColumn]['rating'] = $currentRating;

                if($currentRating > $highestScore
                    && (int)$cells[$keyRow][$keyColumn]['content'] == 0) {
                    $highestScore = $currentRating;
                }

            }
            $loop++;
        }
dump($cells);
        return $this->candidates($cells, $highestScore);
    }


    private function candidates(array $cells, int $highestScore): array
    {
        $candidates = [];

        $this->cellsCheck = $cells;

        foreach ($cells as $row => $column) {
            foreach ($column as $keyColumn => $value) {
                if ($cells[$row][$keyColumn]['rating'] == $highestScore
                    && $cells[$row][$keyColumn]['content'] === 0) {
                    $candidates[] = ['row' => $row, 'column' => $keyColumn];
                }
            }
        }
        dump($candidates);
        return $candidates;
    }
}